<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Applications extends Base
{

    public static function validate($cardselect)
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('event_code')
            ->add_rule('required');

        $val->add('cardselect')
            ->add_rule('required');

        $val->add('name', 'お名前（フルネーム）');

        $val->add('email', 'メールアドレス');

        $val->add('token', '決済トークン');

        $val->add('coupon_code', 'クーポンコード');

        // 新規カード登録 or 会員登録をせずに申し込みの場合は以下必須
        if ($cardselect === '0') {

            $val->field('name')
                ->add_rule('required');

            $val->field('email')
                ->add_rule('required');

            $val->field('token')
                ->add_rule('required');
        }
        return $val;
    }

    public static function get_event_code_by_code($code)
    {
        $application = \DB::select('*')->from('applications')
            ->where('code', '=', $code)
            ->where('disable', '=', 0)
            ->execute()
            ->current();
        return $application['event_code'];
    }

    /**
     * 参加予定イベント一覧取得
     * @return unknown
     */
    public static function get_next_events_applications($username)
    {
        $datas = \DB::select(\DB::expr('applications.code as application_code, applications.cancel, applications.event_code, events.*'))->from('applications')
            ->join('events')
            ->on('applications.event_code', '=', 'events.code')
            ->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'))
            ->where('applications.username', '=', $username)
            ->where('applications.disable', '=', 0)
            ->where('applications.cancel', '=', 0)
            ->order_by('event_date', 'asc')
            ->execute()
            ->as_array();

        return $datas;
    }

    /**
     * 過去の参加イベント一覧取得
     * @return unknown
     */
    public static function get_prev_events_applications($username)
    {
        $datas = \DB::select(\DB::expr('applications.code as application_code, applications.cancel, applications.event_code, events.*'))->from('applications')
            ->join('events')
            ->on('applications.event_code', '=', 'events.code')
            ->where('event_date', '<', \DB::expr('NOW() - INTERVAL 1 DAY'))
            ->where('applications.username', '=', $username)
            ->where('applications.disable', '=', 0)
            ->where('applications.cancel', '=', 0)
            ->order_by('event_date', 'asc')
            ->execute()
            ->as_array();

        return $datas;
    }

    public static function get_applications_by_code($code)
    {

        $select = '';
        $select .= 'ifnull(profiles.name, applications.name)as name, ';
        $select .= 'profiles.profile_image, ';
        $select .= 'ifnull(users.email, applications.email) as email, ';
        $select .= 'profiles.birthday, ';
        $select .= 'member_regist.code as member_regist_code, ';
        $select .= 'member_regist.not_know, ';
        $select .= 'applications.*, ';
        $select .= 'application_credit_payments.sale, ';
        $select .= 'application_credit_payments.cancel as payment_cancel, ';
        $select .= '(select acps.created_at from application_credit_payment_sales as acps where acps.application_code = applications.code) as payment_sale_at, ';
        $select .= '(select pa.created_at from participated_applications as pa where pa.application_code = applications.code) as participated, ';
        $select .= '(select count(*) from applications as tp inner join participated_applications as pa on pa.application_code = tp.code where applications.username != "guest" and applications.username = tp.username) as application_count,';
        $select .= '(select diagnostic_chart_types.type from diagnostic_chart_type_users inner join diagnostic_chart_types on diagnostic_chart_types.code = diagnostic_chart_type_users.type_code where diagnostic_chart_type_users.id = types.id) as type';

        $datas = \DB::select(\DB::expr($select))
            ->from('applications')
            ->join('users', 'LEFT')
            ->on('applications.username', '=', 'users.username')
            ->join('member_regist', 'LEFT')
            ->on('member_regist.username', '=', 'users.username')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'users.username')
            ->join('application_credit_payments', 'LEFT')
            ->on('applications.code', '=', 'application_credit_payments.application_code')
            ->join(array(\DB::expr('select max(id) as id, username from diagnostic_chart_type_users group by username'), 'types'), 'LEFT')
            ->on('types.username', '=', 'member_regist.username')
            ->where('applications.event_code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->where('applications.cancel', '=', 0)
            ->order_by('applications.created_at','asc')
            ->execute()
            ->as_array();

        echo \DB::last_query();

//        return $datas;
    }

    public static function get_cancel_applications_by_code($code)
    {
        $datas = \DB::select(\DB::expr('ifnull(profiles.name, applications.name)as name, profiles.profile_image, ifnull(users.email, applications.email) as email, profiles.birthday, member_regist.code as member_regist_code, applications.*, application_credit_payments.sale, application_credit_payments.cancel as payment_cancel, (select ac.created_at from application_cancels as ac where ac.application_code = applications.code) as cancel_at, (select acpc.created_at from application_credit_payment_cancels as acpc where acpc.application_code = applications.code) as payment_cancel_at'))
            ->from('applications')
            ->join('users', 'LEFT')
            ->on('applications.username', '=', 'users.username')
            ->join('member_regist', 'LEFT')
            ->on('member_regist.username', '=', 'users.username')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'users.username')
            ->join('application_credit_payments', 'LEFT')
            ->on('applications.code', '=', 'application_credit_payments.application_code')
            ->where('applications.event_code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->where('applications.cancel', '=', 1)
            ->order_by('applications.created_at','asc')
            ->execute()
            ->as_array();

        return $datas;
    }

    /**
     * 参加状態確認
     * @param unknown $code
     * @return boolean
     */
    public static function join_status($code)
    {

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

    public static function cancelable_cancel($code)
    {
        \Config::load('payjp', true);

        $select = '';
        $select .= 'ifnull(users.email, applications.email) as email,';
        $select .= 'applications.event_code,';
        $select .= 'applications.cancel,';
        $select .= 'applications.username,';
        $select .= 'profiles.name';

        // 参加状態取得
        $application = \DB::select(\DB::expr($select))
            ->from('applications')
            ->join('users', 'left')
            ->on('applications.username', '=', 'users.username')
            ->join('profiles', 'left')
            ->on('applications.username', '=', 'profiles.username')
            ->where('applications.code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->execute()
            ->current();

        // 存在チェック
        if (empty($application)) {
            return "該当の参加申込が見つかりませんでした";
        }

//        // 自分のかを確認する
//        if ($application['username'] != $username) {
//            return "セキュリティー上の問題が発生いたしました";
//        }

        // キャンセル状況確認
        if ($application['cancel'] != 0) {
            return "この参加申し込みは既にキャンセル済みです";
        }

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            // キャンセルする
            \DB::update('applications')->set(
                array(
                    'cancel' => 1,
                    'updated_at' => \DB::expr('now()'),
                )
            )->where('code', '=', $code)->execute();

            // 申し込みキャンセルデータ作成
            \DB::insert('application_cancels')->set(array(
                'application_code' => $code,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 参加人数を減らす
            \DB::update('events')->set(array(
                'application_num' => \DB::expr('application_num-1')
            ))
                ->where('application_num', '>', 0)
                ->where('code', '=', $application['event_code'])
                ->execute();

            // クレジット決済の場合決済取り消し
            if ($charge_id = ApplicationCreditPayment::getChargeIdByApplicationCode($code)) {
                // 決済データをキャンセル状態に
                \DB::update('application_credit_payments')->set(array(
                    'cancel' => 1,
                    'updated_at' => \DB::expr('now()'),
                ))
                    ->where('application_code', '=', $code)
                    ->execute();

                // 決済キャンセルデータ作成
                \DB::insert('application_credit_payment_cancels')->set(array(
                    'application_code' => $code,
                    'created_at' => \DB::expr('now()'),
                ))->execute();
            
                $payment = new Payment(\Config::get('payjp.private_key'));
                $payment->cancel($charge_id);
            }

            $db->commit_transaction();

            // サンクスメール
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】女子会をキャンセルいたしました。");
            $mail->html_body(\View::forge('email/joshikai/cancel', array(
                'name' => $application['name']
            )));
            $mail->to($application['email']); //送り先

            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();

            throw $e;
        }
    }

    public static function non_cancelable_cancel($code)
    {
        \Config::load('payjp', true);

        $select = '';
        $select .= 'ifnull(users.email, applications.email) as email,';
        $select .= 'applications.event_code,';
        $select .= 'applications.cancel,';
        $select .= 'applications.username,';
        $select .= 'profiles.name';

        // 参加状態取得
        $application = \DB::select(\DB::expr($select))
            ->from('applications')
            ->join('users', 'left')
            ->on('applications.username', '=', 'users.username')
            ->join('profiles', 'left')
            ->on('applications.username', '=', 'profiles.username')
            ->where('applications.code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->execute()
            ->current();

        // 存在チェック
        if (empty($application)) {
            return "該当の参加申込が見つかりませんでした";
        }

//        // 自分のかを確認する
//        if ($application['username'] != $username) {
//            return "セキュリティー上の問題が発生いたしました";
//        }

        // キャンセル状況確認
        if ($application['cancel'] != 0) {
            return "この参加申し込みは既にキャンセル済みです";
        }

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            // キャンセルする
            \DB::update('applications')->set(
                array(
                    'cancel' => 1,
                    'updated_at' => \DB::expr('now()'),
                )
            )->where('code', '=', $code)->execute();

            // 申し込みキャンセルデータ作成
            \DB::insert('application_cancels')->set(array(
                'application_code' => $code,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 参加人数を減らす
            \DB::update('events')->set(array(
                'application_num' => \DB::expr('application_num-1')
            ))
                ->where('application_num', '>', 0)
                ->where('code', '=', $application['event_code'])
                ->execute();
        
            $db->commit_transaction();

            // サンクスメール
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】女子会のお申込みを取り消しました。");
            $mail->html_body(\View::forge('email/joshikai/cancel', array(
                'name' => $application['name']
            )));
            $mail->to($application['email']); //送り先

            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();

            throw $e;
        }
    }

    /**
     * 参加申し込み確認
     */
    private static function completed($event_code, $username, $email = '')
    {

        if ($username == 'guest') {
            // 既存のデータがないか確認
            $data = \DB::select('*')->from('applications')
                ->where('event_code', '=', $event_code)
                ->where('username', '=', $username)
                ->where('email', '=', $email)
                ->where('cancel', '=', 0)
                ->where('disable', '=', 0)
                ->execute()
                ->current();
        } else {
            // 既存のデータがないか確認
            $data = self::join_status($event_code);
        }
        if (empty($data)) {
            return false;
        }
        return true;
    }

    /**
     * 申し込み人数取得
     * @param $event_code
     * @return mixed
     */
    public static function getApplicationCount($event_code)
    {
        $result = \DB::select(\DB::expr('COUNT(*) as count'))
            ->from('applications')
            ->where('event_code', '=', $event_code)
            ->where('cancel', '=', 0)
            ->where('disable', '=', 0)
            ->execute();
        $result_arr = $result->current();
        return $result_arr['count'];
    }

    /**
     * 参加申し込み
     * @param \Model\Payment $payment
     * @param $event_code   イベントコード
     * @param $name         ふりがな
     * @param $email        メールアドレス
     * @param $cardselect   カードID※新規登録時は0
     * @param string $token 決済トークン※新規登録時に必須。カード登録に使用
     * @return bool
     * @throws \Exception
     */
    public static function create(\Model\Payment $payment, $event_code, $cardselect, $name, $email, $token='', $coupon=array())
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            $username = \Auth::get('username');

            $event = self::getByCode('events', $event_code);

            // 下書き
            if (empty($event) || $event['status'] != 1) {
                return "イベントが見つかりませんでした";
            }

            // 申し込み人数
            $application_num = self::getApplicationCount($event_code);

            if (intval($event['limit']) <= intval($application_num)) {
                return "このイベントは満席です";
            }

            //		// 終了チェック
            //		if ($event['event_start_datetime'] < date('Y-m-d H:i:s')) {
            //			return "このイベントは終了しています";
            //		}

            if (self::completed($event_code, $username, $email)) {
                return "この女子会は、すでにお申込みいただいております。";
            }

            // 申し込みイベンドコード生成
            $application_code = self::getNewCode('applications');

            // クーポン情報の初期値設定
            $discount = $coupon ? $coupon['discount']: 0;
            $coupon_code = $coupon ? $coupon['coupon_code']: '';
            $event_coupon_code = $coupon ? $coupon['code']: '';

            $amount = $event['fee'] - $discount; // 支払金額

            // 申し込みイベントデータ作成
            \DB::insert('applications')->set(array(
                'code' => $application_code,
                'event_code' => $event_code,
                'username' => $username,
                'amount' => $amount,
                'fee' => $event['fee'],
                'discount' => $discount,
                'coupon_code' => $coupon_code,
                'payment_method' => 1,
                'name' => $name,
                'email' => $email,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 申し込み割引イベントデータ作成
            if ($event_coupon_code) {
                \DB::insert('application_coupons')->set(array(
                    'application_code' => $application_code,
                    'event_coupon_code' => $event_coupon_code,
                    'discount' => $discount,
                    'created_at' => \DB::expr('now()'),
                ))->execute();
            }

            // 非会員決済 *********************
            if (!$username || $username == 'guest') {

                // 登録カードで決済
                $charge = $payment->chargeByToken(
                    $amount,
                    $token,
                    $application_code,
                    $name,
                    $email
                );
            } // 会員決済 *********************
            else {
                // payjp会員情報取得
                // 該当会員がいない場合は作成、いる場合は更新
                if (!$customer = $payment->getCustomer($username)) {
                    $customer = $payment->createCustomer($username, $name, $email);
                    // トランザクション失敗時の登録取り消し用
                    $new_customer = $customer;
                } else {
                    $payment->updateCustomer($customer, $name, $email);
                }

                // 新しいカードで決済
                if ($cardselect === '0') {
                    $new_card = $payment->createCard($customer, $token, $name);
                    // 登録カードリソースデータ作成（二回目にカードを使う用）
                    \DB::insert('user_credit_cards')->set(array(
                        'username' => $username,
                        'card_id' => $new_card->id,
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                    $charge = $payment->chargeByNewCard(
                        $amount,
                        $customer,
                        $new_card,
                        $application_code,
                        $name,
                        $email
                    );
                } // 登録カードで決済
                else {
                    $customer = $payment->getCustomer($username);
                    $payment->updateCustomer($customer, $name, $email);
                    $charge = $payment->chargeByRegistCard(
                        $amount,
                        $customer,
                        $cardselect,
                        $application_code,
                        $name,
                        $email
                    );
                }
            }

            // クレジット決済イベントデータ作成
            \DB::insert('application_credit_payments')->set(array(
                'application_code' => $application_code,
                'charge_id' => $charge->id,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            $db->commit_transaction();

            // サンクスメール
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】女子会のお申込みありがとうございます。");
            $mail->html_body(\View::forge('email/joshikai/body',
                array(
                    'name' => $name,
                    'event' => $event
                )));
            $mail->to($email); //送り先

            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

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

    public static function force_cancel($code)
    {
        \Config::load('payjp', true);

        // 参加状態取得
        $application = \DB::select(\DB::expr('users.email, applications.event_code, applications.cancel, applications.username, profiles.name'))
            ->from('applications')
            ->join('users')
            ->on('applications.username', '=', 'users.username')
            ->join('profiles')
            ->on('applications.username', '=', 'profiles.username')
            ->where('applications.code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->execute()
            ->current();

        // 存在チェック
        if (empty($application)) {
            return "該当の参加申込が見つかりませんでした";
        }

        // キャンセル状況確認
        if ($application['cancel'] != 0) {
            return "この参加申し込みは既にキャンセル済みです";
        }

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            // キャンセルする
            \DB::update('applications')->set(
                array(
                    'cancel' => 1,
                    'updated_at' => \DB::expr('now()'),
                )
            )->where('code', '=', $code)->execute();

            // 申し込みキャンセルデータ作成
            \DB::insert('application_cancels')->set(array(
                'application_code' => $code,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 参加人数を減らす
            \DB::update('events')->set(array(
                'application_num' => \DB::expr('application_num-1')
            ))
                ->where('application_num', '>', 0)
                ->where('code', '=', $application['event_code'])
                ->execute();

            // クレジット決済の場合決済取り消し
            if ($charge_id = ApplicationCreditPayment::getChargeIdByApplicationCode($code)) {
                // 決済データをキャンセル状態に
                \DB::update('application_credit_payments')->set(array(
                    'cancel' => 1,
                    'updated_at' => \DB::expr('now()'),
                ))
                    ->where('application_code', '=', $code)
                    ->execute();

                // 決済キャンセルデータ作成
                \DB::insert('application_credit_payment_cancels')->set(array(
                    'application_code' => $code,
                    'created_at' => \DB::expr('now()'),
                ))->execute();

                $payment = new Payment(\Config::get('payjp.private_key'));
                $payment->cancel($charge_id);
            }

            $db->commit_transaction();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();

            throw $e;
        }
    }

}
