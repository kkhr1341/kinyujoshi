<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Consultations extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('message', 'お問い合わせ内容')
            ->add_rule('required');

        $val->add('email', 'メールアドレス')
            ->add_rule('required');

        return $val;
    }

    public static function create($params, $username)
    {

        $code = self::getNewCode('consultations');
        $params['username'] = $username;
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('consultations')->set($params)->execute();

        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject("[きんゆう女子。] お問合せ確認メール");
        $email->html_body(\View::forge('email/consultation/body', array()));
        $email->to($params['email']); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("[きんゆう女子。] お問合せがありました");
        $name = $params['name'];
        $message = $params['message'];
        $email = $params['email'];
        $email02->html_body(\View::forge('email/consultation/return',
            array(
                'name' => $name,
                'message' => $message,
                'email' => $email
            )));
        $email02->to('cs@kinyu-joshi.jp'); //送り先

        $email02->return_path('support@kinyu-joshi.jp');
        $email02->send();

        return $params;
    }

    public static function lists()
    {
        return \DB::select(
                \DB::expr('consultations.*'),
                \DB::expr('(select count(*) from consultation_reply_mails where consultation_reply_mails.consultation_code = consultations.code) as reply_num')
            )
            ->from('consultations')
            ->where('consultations.disable', '=', 0)
            ->order_by('consultations.created_at', 'desc')
            ->execute()
            ->as_array();
    }

    public static function findByCode($code)
    {
        return \DB::select(
                \DB::expr('consultations.*')
            )
            ->from('consultations')
            ->where('consultations.code', '=', $code)
            ->where('consultations.disable', '=', 0)
            ->execute()
            ->current();
    }
}
