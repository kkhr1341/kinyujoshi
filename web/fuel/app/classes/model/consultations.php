<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Consultations extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name', 'お名前');

        $val->add('message', 'お問い合わせ内容')
            ->add_rule('required');

        $val->add('email', 'メールアドレス');

        return $val;
    }

    public static function create($params, $username)
    {
        $code = self::getNewCode('consultations');
        $params['username'] = $username;
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('consultations')->set($params)->execute();

        // サンクスメール
        if ($params['email']) {
            $email01 = \Email::forge('jis');
            $email01->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $email01->subject("[きんゆう女子。] 教えていただき、ありがとうございます！");
            $email01->html_body(\View::forge('email/consultation/body', array()));
            $email01->to($params['email']); //送り先
            $email01->return_path('support@kinyu-joshi.jp');
            $email01->send();
        }

        // 通知メール
        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("[きんゆう女子。]もやもやの入力がありました。");
        $email02->html_body(\View::forge('email/consultation/return',
            array(
                'name' => $params['name'],
                'message' => $params['message'],
                'email' => $params['email']
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
            ->execute('slave')
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
            ->execute('slave')
            ->current();
    }
}
