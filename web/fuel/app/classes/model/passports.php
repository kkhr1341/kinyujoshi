<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Passports extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('message', 'できたら嬉しいこと')
            ->add_rule('required');

        return $val;
    }

    public static function save($params, $username)
    {
        $profile = \DB::select('*')
            ->from('profiles')
            ->where('profiles.username', '=', $username)
            ->execute()
            ->current();

        $params['username'] = $username;
        $params['created_at'] = \DB::expr('now()');;

        \DB::insert('passports')
            ->set($params + array('username' => $username))
            ->execute();

        $email03 = \Email::forge('jis');
        $email03->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email03->subject("【きんゆう女子。】きん女。パスポートにメッセージがありました。");

        $name    = $profile['name'];
        $message = $params['message'];

        $email03->html_body(\View::forge('email/passport/return',
            array(
                'name' => $name,
                'message' => $message,
            )));
        $email03->to('cs@kinyu-joshi.jp'); //送り先

        $email03->return_path('support@kinyu-joshi.jp');
        $email03->send();

        return $params;
    }
}