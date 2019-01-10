<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

use \Model\PaymentPayjp;
use \Model\Payment\Payjp;

class Applications extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('event_code')
            ->add_rule('required');

        $val->add('cardselect');

        $val->add('name', 'お名前（フルネーム）');

        $val->add('email', 'メールアドレス');

        $val->add('token', '決済トークン');

        $val->add('coupon_code', 'クーポンコード');

        $val->add('message');

        // 新規カード登録 or 会員登録をせずに申し込みの場合は以下必須
        $val->field('name')
            ->add_rule('required');

        $val->field('email')
            ->add_rule('required');

        $val->field('token');

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

        $select = '';
        $select .= 'applications.code as application_code, ';
        $select .= 'exists(select "x" from application_cancels where applications.code = application_cancels.application_code) as cancel,';
        $select .= 'applications.event_code, ';
        $select .= 'events.*';

        $datas = \DB::select(\DB::expr($select))
            ->from('applications')
            ->join('events')
            ->on('applications.event_code', '=', 'events.code')
            ->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'))
            ->where('applications.username', '=', $username)
            ->where('applications.disable', '=', 0)
            ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
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
        $select = '';
        $select .= 'applications.code as application_code,';
        $select .= 'exists(select "x" from application_cancels where applications.code = application_cancels.application_code) as cancel,';
        $select .= 'applications.event_code,';
        $select .= 'events.*';

        $datas = \DB::select(\DB::expr($select))->from('applications')
            ->join('events')
            ->on('applications.event_code', '=', 'events.code')
            ->where('event_date', '<', \DB::expr('NOW() - INTERVAL 1 DAY'))
            ->where('applications.username', '=', $username)
            ->where('applications.disable', '=', 0)
            ->where(\DB::expr('not exists(select "x" from application_credit_payment_cancels where applications.code = application_credit_payment_cancels.application_code)'))
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
        $select .= 'application_credit_payments.charge_id, ';
        $select .= 'exists(select "x" from application_credit_payment_sales where applications.code = application_credit_payment_sales.application_code) as sale,';
        $select .= 'exists(select "x" from application_credit_payment_cancels where applications.code = application_credit_payment_cancels.application_code) as payment_cancel,';
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
            ->on('application_credit_payments.application_code', '=', 'applications.code')
            ->join(array(\DB::expr('select max(id) as id, username from diagnostic_chart_type_users group by username'), 'types'), 'LEFT')
            ->on('types.username', '=', 'member_regist.username')
            ->where('applications.event_code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
            ->order_by('applications.created_at','asc')
            ->execute()
            ->as_array();

        return $datas;
    }

    public static function get_cancel_applications_by_code($code)
    {

        $select = '';
        $select .= 'ifnull(profiles.name, applications.name)as name, ';
        $select .= 'profiles.profile_image, ';
        $select .= 'ifnull(users.email, applications.email) as email, ';
        $select .= 'profiles.birthday, ';
        $select .= 'member_regist.code as member_regist_code, ';
        $select .= 'applications.*, ';
        $select .= 'application_credit_payments.charge_id, ';
        $select .= 'exists(select "x" from application_credit_payment_sales where applications.code = application_credit_payment_sales.application_code) as sale,';
        $select .= 'exists(select "x" from application_credit_payment_cancels where applications.code = application_credit_payment_cancels.application_code) as payment_cancel,';
        $select .= '(select ac.created_at from application_cancels as ac where ac.application_code = applications.code) as cancel_at, ';
        $select .= '(select acpc.created_at from application_credit_payment_cancels as acpc where acpc.application_code = applications.code) as payment_cancel_at';

        $datas = \DB::select(\DB::expr($select))
            ->from('applications')
            ->join('users', 'LEFT')
            ->on('applications.username', '=', 'users.username')
            ->join('member_regist', 'LEFT')
            ->on('member_regist.username', '=', 'users.username')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'users.username')
            ->join('application_credit_payments', 'LEFT')
            ->on('application_credit_payments.application_code', '=', 'applications.code')
            ->where('applications.event_code', '=', $code)
            ->where('applications.disable', '=', 0)
            ->where(\DB::expr('exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
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
    public static function join_status($code, $username)
    {
        $data = \DB::select('*')
            ->from('applications')
            ->where('applications.event_code', '=', $code)
            ->where('applications.username', '=', $username)
            ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
            ->where('applications.disable', '=', 0)
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
        $select .= 'exists(select "x" from application_cancels where applications.code = application_cancels.application_code) as cancel,';
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
                \DB::update('application_credit_payments')
                    ->set(array(
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

                \Config::load('payjp', true);
                $payment = new PaymentPayjp(new Payjp(\Config::get('payjp.private_key')));
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
        $select .= 'exists(select "x" from application_cancels where applications.code = application_cancels.application_code) as cancel,';
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
                ->where('applications.event_code', '=', $event_code)
                ->where('applications.username', '=', $username)
                ->where('applications.email', '=', $email)
                ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
                ->where('applications.disable', '=', 0)
                ->execute()
                ->current();
        } else {
            // 既存のデータがないか確認
            $data = self::join_status($event_code, $username);
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
            ->where('applications.event_code', '=', $event_code)
            ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
            ->where('applications.disable', '=', 0)
            ->execute();
        $result_arr = $result->current();
        return $result_arr['count'];
    }

    /**
     * 参加申し込み
     * @param string $username     ユーザーネーム
     * @param string $event_code   イベントコード
     * @param string $name         ふりがな
     * @param string $email        メールアドレス
     * @param string $coupon_code  クーポンコード
     * @return bool
     * @throws \Exception
     */
    public static function create(
        $username,
        $event_code,
        $name,
        $email,
        $coupon_code='',
        $message=''
    ) {
        try {

            $event = self::getByCode('events', $event_code);

            // 下書き
            if (empty($event) || $event['status'] != 1) {
                throw new \Exception("イベントが見つかりませんでした");
            }

            // 申し込み人数
            $application_num = self::getApplicationCount($event_code);

            if (intval($event['limit']) <= intval($application_num)) {
                throw new \Exception("このイベントは満席です");
            }

            //		// 終了チェック
            //		if ($event['event_start_datetime'] < date('Y-m-d H:i:s')) {
            //			return "このイベントは終了しています";
            //		}

            if (self::completed($event_code, $username, $email)) {
                throw new \Exception("この女子会は、すでにお申込みいただいております");
            }

            // 申し込みイベンドコード生成
            $application_code = self::getNewCode('applications');

            // クーポン情報情報
            $coupon = self::getByEventCodeAndCouponCode(
                $event_code,
                $coupon_code
            );

            // 支払金額
            $amount = $event['fee'] - $coupon['discount'];

            $params = array(
                'code' => $application_code,
                'event_code' => $event_code,
                'username' => $username,
                'amount' => $amount,
                'fee' => $event['fee'],
                'discount' => $coupon['discount'],
                'coupon_code' => $coupon['coupon_code'],
                'payment_method' => 1,
                'message' => $message,
                'name' => $name,
                'email' => $email,
                'created_at' => \DB::expr('now()'),
            );

            // 申し込みイベントデータ作成
            \DB::insert('applications')->set($params)->execute();

            // 申し込み割引イベントデータ作成
            if ($coupon['code']) {
                \DB::insert('application_coupons')->set(array(
                    'application_code' => $application_code,
                    'event_coupon_code' => $coupon['code'],
                    'discount' => $coupon['discount'],
                    'created_at' => \DB::expr('now()'),
                ))->execute();
            }

            return $params;
        } catch (\Exception $e) {

            throw $e;
        }
    }

    /**
     * クーポン情報取得
     * @param string $event_code  イベントコード
     * @param string $coupon_code クーポンコード
     * @return array
     */
    public static function getByEventCodeAndCouponCode($event_code, $coupon_code)
    {
        $total = \DB::select('*')
            ->from('event_coupons')
            ->where('disable', '=', 0)
            ->where('coupon_code', '=', $coupon_code)
            ->where('event_code', '=', $event_code);

        $coupon = $total->execute()->current() ?: array();

        return array_merge(array(
            'discount' => 0,
            'coupon_code' => '',
            'code' => '',
        ), $coupon);
    }
}
