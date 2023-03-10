<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class RegistReminder extends Base
{

    /**
     * アクセストークンの有効性確認
     * @param $access_token
     * @return bool
     */
    public static function get_valid($access_token)
    {
        $result = \DB::select('*')->from('regist_reminders')
            ->where('access_token', '=', $access_token)
            ->where('expires', '>=', date('Y-m-d H:i:s'))
            ->execute('slave')->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('access_token', '認証トークン')
            ->add_rule('required');

        $access_token = \Input::post('access_token');

        $val->add('email', 'メールアドレス')
            ->add_rule('valid_email')
            ->add_rule(
                function($email) use ($access_token) {

                    if (!$regist_reminder = self::get_valid($access_token)) {
                        \Validation::active()->set_message('closure', '認証トークンの有効期限がきれました。');
                        return false;
                    }

                    $member_regist = \DB::select('*')
                        ->from('member_regist')
                        ->where('id', '=', $regist_reminder['member_regist_id'])
                        ->execute()
                        ->current();

                    if ($member_regist['username']) {
                        \Validation::active()->set_message('closure', 'このメールアドレスですでにメンバー登録がされているようです。');
                        return false;
                    }

                    $select = \DB::select("email")
                        ->where('email', '=', $member_regist['email'])
                        ->from('users');

                    $result = $select->execute();

                    if ($result->count() > 0) {
                        \Validation::active()->set_message('closure', 'このメールアドレスですでにメンバー登録がされているようです。');
                        return false;
                    } else {
                        return true;
                    }
                });

        $val->add('password', '新しいパスワード')
            ->add_rule('required')
            ->add_rule('trim');

        $val->add('password_confirm', 'パスワード再入力')
            ->add_rule('required')
            ->add_rule('trim')
            ->add_rule('match_field', 'password');

        return $val;
    }

    /**
     * 本会員登録誘導メール送信
     * @param $email
     * @param $username
     * @return bool
     * @throws \Exception
     */
    public static function send($member_regist_id, $email)
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            // Token作成
            $access_token = \Str::random('unique');

            \DB::insert('regist_reminders')->set(array(
                'member_regist_id' => $member_regist_id,
                'access_token' => $access_token,
                'expires' => date('Y-m-d H:i:s', strtotime("+90 days")),
                'email' => $email,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            $member_regist = \DB::select('*')
                ->from('member_regist')
                ->where('id', '=', $member_regist_id)
                ->execute()
                ->current();

            $host = \Uri::base();
            $url = $host . 'login/resetting_pass_exuser?access_token=' . $access_token;

            // ユーザー宛にメール送信
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】マイページのアカウント作成方法のご案内です。");
            $mail->attach(DOCROOT.'images/kinyu-logo.png', true);
            $mail->html_body(\View::forge('email/regist_reminder/body',
                array(
                    'name' => $member_regist['name'],
                    'url' => $url,
                    'host' => $host,
                )));
            $mail->to($email); //送り先
            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

            // 関係者に送信通知メール
            $email02 = \Email::forge('jis');
            $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $email02->subject("【きんゆう女子。】パスワード設定メールが送信されました");
            $email02->html_body(\View::forge('email/regist_reminder/return',
                array(
                    'name' => $member_regist['name'],
                    'url' => $url,
                    'host' => $host,
                )));
            $email02->to('support@kinyu-joshi.jp'); //送り先
            $email02->return_path('support@kinyu-joshi.jp');
            $email02->send();

            $db->commit_transaction();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();
            echo $e;
            throw $e;
        }
    }

    /**
     * 本登録
     * @param $member_regist_id
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public static function regist($member_regist_id, $password)
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            $member_regist = \DB::select('*')->from('member_regist')
                ->where('id', '=', $member_regist_id)
                ->execute()->current();

            $username = \Str::random('alnum', 16);

            \Auth::create_user(
                $username,
                $password,
                $member_regist["email"],
                1
            );

            // プロフィール登録
            $profile_code = Profiles::getNewCode('profiles', 6);

            $profile = array(
                'code' => $profile_code,
                'username' => $username,
                'name' => $member_regist['name'],
                'name_kana' => $member_regist['name_kana'],
                'nickname' => $member_regist['name'],
                'birthday' => $member_regist['age'],
                'url' => '',
                'profile_image' => '',
                'introduction' => $member_regist['introduction'],
            );

            Profiles::create($profile);

            \DB::update('member_regist')->set(array(
                'username' => $username,
            ))->where('id', '=', $member_regist_id)->execute();

            // ユーザー宛にメール送信
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】パスワードの設定が完了しました。");
            $mail->html_body(\View::forge('email/regist_reminder/complete'));
            $mail->to($member_regist["email"]); //送り先

            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

            $db->commit_transaction();
        } catch (Exception $e) {
            $db->rollback_transaction();
            \Log::error('register error::' . $e->getMessage());
            throw $e;
        }

        return array();
    }
}
