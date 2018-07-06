<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Userwithdrawal extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('withdrawal_reasons', '退会理由')
            ->add_rule('required');

        $val->add('message');

        return $val;
    }

    /**
     * ユーザーデータの物理削除
     * @param $username
     */
    public static function deleteUser($username)
    {
        // 退会者情報削除
        $user = \DB::select("*")->from('users')
            ->where(array('username' => $username))
            ->execute()
            ->current();

        \DB::delete('member_regist')
            ->where(array('username' => $username))
            ->execute();

        \DB::delete('profiles')
            ->where(array('username' => $username))
            ->execute();

        \DB::delete('users_reminders')
            ->where(array('username' => $username))
            ->execute();

        \DB::delete('change_email_histories')
            ->where(array('username' => $username))
            ->execute();

        \DB::delete('users_providers')
            ->where(array('parent_id' => $user['id']))
            ->execute();

        // 女子会参加履歴削除
        $applications = \DB::select("*")->from('applications')
            ->where(array('username' => $username))
            ->execute()
            ->as_array();

        foreach ($applications as $key => $application) {

            \DB::delete('event_mails')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('event_remind_mails')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('application_cancels')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('application_credit_payment_cancels')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('application_credit_payment_sales')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('application_credit_payments')
                ->where(array('application_code' => $application['code']))
                ->execute();

            \DB::delete('participated_applications')
                ->where(array('application_code' => $application['code']))
                ->execute();
        }

        \DB::delete('applications')
            ->where(array('username' => $username))
            ->execute();

        \DB::delete('users')
            ->where(array('username' => $username))
            ->execute();
    }

    /**
     * 退会処理
     * @param $username string 退会者ユーザーコード
     * @param $message string 退会理由テキスト
     * @param $reasons array 退会理由
     * @return bool
     * @throws \Exception
     */
    public static function withdrawal($username, $message, $reasons=array())
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            $profile = \DB::select('*')
                ->from('profiles')
                ->where('disable', '=', 0)
                ->where('username', '=', $username)
                 ->execute()
                ->current();

            // 退会情報
            $user_withdrawal_code = self::getNewCode('user_withdrawal');
            \DB::insert('user_withdrawal')->set(array(
                'code' => $user_withdrawal_code,
                'message' => $message,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 退会理由
            foreach ($reasons as $reason) {
                $user_withdrawal_reason_code = self::getNewCode('user_withdrawal_reasons');
                \DB::insert('user_withdrawal_reasons')->set(array(
                    'code' => $user_withdrawal_reason_code,
                    'user_withdrawal_code' => $user_withdrawal_code,
                    'withdrawal_reason_code' => $reason['code'],
                    'created_at' => \DB::expr('now()'),
                ))->execute();

                if (isset($reason['reason_text']) && $reason['reason_text']) {
                    // insert user_withdrawal_reason_texts
                    $user_withdrawal_reason_text_code = self::getNewCode('user_withdrawal_reason_texts');
                    \DB::insert('user_withdrawal_reason_texts')->set(array(
                        'code' => $user_withdrawal_reason_text_code,
                        'user_withdrawal_reason_code' => $user_withdrawal_reason_code,
                        'reason_text' => $reason['reason_text'],
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                }
            }

            $user = \DB::select("*")
                ->from('users')
                ->where(array('username' => $username))
                ->execute()
                ->current();

            self::deleteUser($username);

            $db->commit_transaction();

            // 退会メール送信
            $email = \Email::forge('jis');
            $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $email->subject("【きんゆう女子。】メンバー退会完了のお知らせ");

            $email->html_body(\View::forge('email/withdrawal/body', array(
                'name' => $profile["name"]
            )));
            $email->to($user['email']); //送り先
            $email->send();

            $email02 = \Email::forge('jis');
            $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $email02->subject("【きんゆう女子。】メンバー退会がありました");

            $email02->html_body(\View::forge('email/withdrawal/return'));
            $email02->to('system@sundaylunch.jp'); //送り先
            $email02->send();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();

            throw $e;
        }
    }
}
