<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Profiles extends Base
{

    public static function validate($username)
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('profile_image', 'プロフィール画像');

        $val->add('catchcopy', 'ひとことキャッピコピー');

        $val->add('nickname', '表示名');

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule(
                function($email) use($username) {
                    $select = \DB::select("email")
                        ->where('email', '=', $email)
                        ->where('username', '<>', $username)
                        ->from('users');

                    $result = $select->execute();

                    if ($result->count() > 0) {
                        \Validation::active()->set_message('closure', 'このメールアドレスですでにメンバー登録がされているようです。');
                        return false;
                    } else {
                        return true;
                    }
                });

        $val->add('url', '個人で発信しているブログなど');

        $val->add('introduction', '自己紹介');

        return $val;
    }

    public static function create($params)
    {

        $params['created_at'] = \DB::expr('now()');

        \DB::insert('profiles')->set($params)->execute();

        return true;
    }

    public static function get($username)
    {

        return \DB::select('*')->from('profiles')->where('disable', '=', 0)->where('username', '=', $username)->execute()->current();

    }

    public static function save($params)
    {

        $username = \Auth::get('username');
        $email = \Auth::get_email();

        // メールアドレスの変更確認
        \DB::update('users')->set(array(
            'email' => $params['email']
        ))->where('username', '=', $username)->execute();

        \DB::update('member_regist')->set(array(
            'email' => $params['email']
        ))->where('username', '=', $username)->execute();

        \DB::update('profiles')->set(array(
            'catchcopy' => $params['catchcopy'],
            'nickname' => $params['nickname'],
            'name' => $params['name'],
            'url' => $params['url'],
            'introduction' => $params['introduction'],
            'profile_image' => $params['profile_image']
        ))->where('username', '=', $username)->execute();

        // メールアドレスの変更通知を通知
        if ($email != $params['email']) {

            // 変更履歴
            \DB::insert('change_email_histories')->set(array(
                'username' => $username,
                'before_email' => $email,
                'after_email' => $params['email'],
            ))->execute();

            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】メールアドレス変更通知");

            $mail->attach(DOCROOT.'images/kinyu-logo.png', true);

            $mail->html_body(\View::forge('email/email_change_notify/return',
                array(
                    'username' => $username,
                    'before_email' => $email,
                    'after_email'  => $params['email'],
                )));
            $mail->to('support@kinyu-joshi.jp'); //送り先
            $mail->send();
        }

        return true;
    }

    public static function lists($mode = null, $limit = null)
    {

        $datas = \DB::select(\DB::expr('*, profiles.code'))
            ->from('profiles')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('profiles.disable', '=', 0);

        // if ($mode === null) {
        // }
        // else {
        //   $datas = $datas->where('status', '=', $mode);
        // }

        // if ($open === null) {
        // }
        // else {
        //   $datas = $datas->where('created_at', '<', \DB::expr('NOW()'));
        // }

        // if ($section_code === null) {
        // }
        // else {
        //   $datas = $datas->where('section_code', '=', $section_code);
        // }

        $datas = $datas->order_by('profiles.id', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }
}
