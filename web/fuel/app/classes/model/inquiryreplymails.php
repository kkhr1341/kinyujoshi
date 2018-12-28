<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Inquiryreplymails extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code');

        $val->add('subject');

        $val->add('body');

        return $val;
    }

    public static function create($params, $mail, $username)
    {
        $data = array();
        $data['username'] = $username;
        $data['email'] = $mail;
        $data['inquiry_code'] = $params['code'];
        $data['subject'] = $params['subject'];
        $data['body'] = $params['body'];
        $data['created_at'] = \DB::expr('now()');
        \DB::insert('inquiry_reply_mails')
            ->set($data)
            ->execute();

        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject($params['subject']);

        $email->body($params['body']);
        $email->to($mail); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        return $params;
    }
}
