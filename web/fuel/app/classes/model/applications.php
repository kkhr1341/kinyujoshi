<?php

namespace Model;
use Oil\Exception;

use Payjp\Payjp;
//use Payjp\Charge;
use \Model\Payment;

require_once(dirname(__FILE__)."/base.php");

class Applications extends Base {
	
	/**
	 * 参加イベント一覧取得
	 * @return unknown
	 */
	public static function get_applications() {

		$username = \Auth::get('username');
		
		$datas = \DB::select(\DB::expr('applications.code as application_code, applications.cancel, events.*'))->from('applications')
			->join('events', 'left')
			->on('applications.event_code', '=', 'events.code')
			->where('applications.username', '=', $username)
			->where('applications.disable', '=', 0)
			->execute()
			->as_array();
		
		return $datas;
	}
	
	/**
	 * 参加状態確認
	 * @param unknown $code
	 * @return boolean
	 */
	public static function join_status($code) {

		$username = \Auth::get('username');
		
		$data = \DB::select('*')->from('applications')
			->where('event_code', '=', $code)
			->where('username', '=', $username)
			->where('cancel', '=', 0)
			->where('disable', '=', 0)
			->execute()
			->current();
		
		if (empty($data)) {
			return false;
		}
		
		return true;
	}

	public static function cancel($params) {

		$username = \Auth::get('username');
		
		// 参加状態取得
		$application = self::getByCode('applications', $params['code']);
		
		// 存在チェック
		if (empty($application)) {
			return "該当の参加申込が見つかりませんでした";
		}
		
		// 自分のかを確認する
		if ($application['username'] != $username) {
			return "セキュリティー上の問題が発生いたしました";
		}
		
		// キャンセル状況確認
		if ($application['cancel'] != 0) {
			return "この参加申し込みは既にキャンセル済みです";
		}
		
		// キャンセルする
		\DB::update('applications')->set(array('cancel' => 1))->where('code', '=', $params['code'])->execute();
		// 参加人数を減らす
		\DB::update('events')->set(array(
			'application_num' => \DB::expr('application_num-1')
		))->where('code', '=', $application['event_code'])->execute();
		
		return true;
	}

	private static function getCustomerOfPayjp($username) {
	    try {
            return \Payjp\Customer::retrieve($username);
        } catch (\Payjp\Error\InvalidRequest $e) {
	        return false;
        }
    }
    private static function createCustomerOfPayjp($username) {
        try {
            return \Payjp\Customer::create(array(
                'id' => $username,
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("顧客情報の登録に失敗しました。");
        }
    }
    private static function createCardOfPayjp(\Payjp\Customer $customer, $token) {
	    try {
            return $customer->cards->create(array(
                'card' => $token
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
	        throw new \Exception("既にご登録のあるカードです。");
        }
    }
	
	/**
	 * 参加申し込み
	 * @param unknown $params
	 * @return string|boolean
	 */
	public static function create($params) {

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            $username = \Auth::get('username');

            $event = self::getByCode('events', $params['event_code']);

            // 申し込み人数
            $result = \DB::select(\DB::expr('COUNT(*) as count'))
                ->from('applications')
                ->where('event_code', '=', $params['event_code'])
                ->where('cancel', '=', 0)
                ->where('disable', '=', 0)
                ->execute();
            $result_arr = $result->current();
            $application_num = $result_arr['count'];

            // 下書き
            if (empty($event) || $event['status'] != 1) {
                return "イベントが見つかりませんでした";
            }

            if (intval($event['limit']) <= intval($application_num)) {
                return "このイベントは満席です";
            }

    //		// 終了チェック
    //		if ($event['event_start_datetime'] < date('Y-m-d H:i:s')) {
    //			return "このイベントは終了しています";
    //		}

            // 既存のデータがないか確認
            $data = \DB::select('*')->from('applications')
                        ->where('event_code', '=', $params['event_code'])
                        ->where('username', '=', $username)
                        ->where('cancel', '=', 0)
                        ->where('disable', '=', 0)
                        ->execute()
                        ->current();

            if (!empty($data)) {
                return "既に参加申し込みずみです";
            }

            // 申し込みイベンドコード生成
            $application_code = self::getNewCode('applications');

            // 申し込みイベントデータ作成
            \DB::insert('applications')->set(array(
                'code' => $application_code,
                'event_code' => $params['event_code'],
                'username' => $username,
                'amount' => $event['fee'],
                'payment_method' => 1,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 与信
            \Config::load('payjp', true);

            $payment = new Payment(\Config::get('payjp.private_key'));

            if ($username) {
                // 会員登録して申し込み

                // Payjpに顧客情報登録 or 取得
                if (!$customer = $payment->getCustomer($username)) {
                    $customer = $payment->createCustomer($username);
                    // トランザクション失敗時の登録取り消し用
                    $new_customer = $customer;
                }

                if ($params['cardselect'] === '0') {
                    // 新しいカードで決済
                    $new_card = $payment->createCard($customer, $params['token']);
                    // 登録カードリソースデータ作成（二回目にカードを使う用）
                    \DB::insert('user_credit_cards')->set(array(
                        'username' => $username,
                        'card_id' => $new_card->id,
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                    $charge = $payment->chargeByNewCard($event['fee'], $customer, $new_card, $application_code);
                } else {
                    // 登録カードで決済
                    $charge = $payment->chargeByRegistCard(
                        $event['fee'],
                        $customer,
                        $params['cardselect'],
                        $application_code
                    );
                }
            } else {
                // 会員登録せずに申し込み

                // 登録カードで決済
                $charge = $payment->chargeByToken(
                    $event['fee'],
                    $params['token'],
                    $application_code,
                    $params['name'],
                    $params['email']
                );
            }

            // クレジット決済イベントデータ作成
            \DB::insert('application_credit_payments')->set(array(
                'application_code' => $application_code,
                'charge_id' => $charge->id,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            $db->commit_transaction();

            return true;
        } catch (\Exception $e) {

            $db->rollback_transaction();

            if (isset($new_customer)) {
                $new_customer->delete();
            }

            if (isset($new_card)) {
                $new_card->delete();
            }

            throw $e;
        }
	}
}
