<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class UserReminder extends Base {

    public static function get_valid($access_token)
    {
        $result = \DB::select('*')->from('users_reminders')
            ->where('access_token', '=', $access_token)
            ->where('expires', '>=', date('Y-m-d H:i:s'))
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule('exists', array('table' => 'users', 'field' => 'email'));

        return $val;
    }

    public static function validate_reset()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('password', '新しいパスワード')
            ->add_rule('required')
            ->add_rule('trim');

        $val->add('password_confirm', 'パスワード再入力')
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('match_field', 'password');

        return $val;
    }

    public static function create($email, $username) {

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            // Token作成
            $access_token = \Str::random('unique');

            \DB::insert('users_reminders')->set(array(
                'username' => $username,
                'access_token' => $access_token,
                'expires' => date('Y-m-d H:i:s', strtotime("+30 minutes")),
                'created_at' => \DB::expr('now()'),
            ))->execute();

            $db->commit_transaction();

            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】パスワード再設定URLのお知らせ");

            $url = \Uri::base() . 'login/resetting_pass?access_token=' . $access_token;

            $mail->html_body(\View::forge('email/reminder/body',
                array(
                    'url' => $url,
                )));
            $mail->to($email); //送り先
            $mail->send();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();

            throw $e;
        }
    }


    public static function reset($username, $password) {
        try {
            \DB::start_transaction();

            $old_password = \Auth::reset_password($username);

            \Auth::change_password($old_password, $password, $username);

            \DB::commit_transaction();

            return true;
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw $e;
        }
    }
}