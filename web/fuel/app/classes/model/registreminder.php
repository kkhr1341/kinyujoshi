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
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
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

    /**
     * 本会員登録誘導メール送信
     * @param $email
     * @param $username
     * @return bool
     * @throws \Exception
     */
    public static function send($member_regist_id)
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
                'created_at' => \DB::expr('now()'),
            ))->execute();

            // 参加状態取得
            $member_regist = \DB::select('*')
                ->from('member_regist')
                ->where('id', '=', $member_regist_id)
                ->execute()
                ->current();

            $email = $member_regist['email'];

            echo $email . "email";

            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】お知らせ");

            $mail->attach(DOCROOT.'public/images/kinyu-logo.png', true);

            $url = \Uri::base() . 'login/regist_reminder?access_token=' . $access_token;

            $mail->html_body(\View::forge('email/regist_reminder/body',
                array(
                    'url' => $url,
                )));
            $mail->to($email); //送り先
            $mail->send();

            $db->commit_transaction();

            return true;
        } catch (\Exception $e) {
            $db->rollback_transaction();
            echo $e;
            throw $e;
        }
    }

    /**
     * パスワードリセット
     * @param $username
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public static function regist($member_regist_id, $password)
    {
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            $username = \Str::random('alnum', 16);
            $user_id = \Auth::create_user(
                $username,
                $params["password"],
                $params["email"],
                1
            );

            $member_regist = \DB::select('*')->from('member_regist')
                ->where('id', '=', $member_regist_id)
                ->execute()->current();

            // プロフィール登録
            $profile_code = Profiles::getNewCode('profiles', 6);

            $profile = [
                'code' => $profile_code,
                'username' => $username,
                'name' => $member_regist['name'],
                'name_kana' => $member_regist['name_kana'],
                'nickname' => $member_regist['name'],
                'birthday' => $member_regist['age'],
                'url' => '',
                'introduction' => $member_regist['introduction'],
            ];

            Profiles::create($profile);

            $db->commit_transaction();

            // ログイン
            \Auth::instance()->force_login((int)$user_id);
        } catch (Exception $e) {
            $db->rollback_transaction();
            \Log::error('register error::' . $e->getMessage());
            throw $e;
        }

/*
        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject("【きんゆう女子。】メンバー登録ありがとうございます(*^^*)");

        $name = $params['name'];

        $email->html_body(\View::forge('email/regist/body',
            array(
                'name' => $name
            )));
        $email->to($params['email']); //送り先
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("【きんゆう女子。】メンバー登録がありました！");

        $name = $params['name'];
        $name_kana = $params['name_kana'];
        $age = $params['birthday'];
        $not_know = $params['not_know'];
        $interest = $params['interest'];
        $ask = $params['ask'];
        $income = $params['income'];
        $where_from = $params['where_from'];
        $where_from_other = $params['where_from_other'];
        $transmission = $params['transmission'];
        $email = $params['email'];
        $facebook = "";
        $job_kind = $params['job_kind'];
        $introduction = $params['introduction'];

        $email02->html_body(\View::forge('email/regist/return',
            array(
                'name' => $name,
                'name_kana' => $name_kana,
                'age' => $age,
                'not_know' => $not_know,
                'interest' => $interest,
                'ask' => $ask,
                'income' => $income,
                'where_from' => $where_from,
                'where_from_other' => $where_from_other,
                'transmission' => $transmission,
                'email' => $email,
                'facebook' => $facebook,
                'job_kind' => $job_kind,
                'introduction' => $introduction
            )));
        $email02->to('cs@kinyu-joshi.jp'); //送り先
        $email02->send();
*/

        return $params;
    }
}