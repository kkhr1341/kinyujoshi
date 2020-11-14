<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Inquiries extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('name_kana', 'お名前(カナ)')
            ->add_rule('required');

        $val->add('email', 'メールアドレス')
            ->add_rule('required');

        $val->add('category_code', 'お問い合わせ種別')
            ->add_rule('required');

        $val->add('message', 'お問い合わせ内容')
            ->add_rule('required');

        return $val;
    }

    public static function create($params, $username)
    {

        $code = self::getNewCode('inquiries');
        $params['username'] = $username;
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        $params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        \DB::insert('inquiries')->set($params)->execute();

        $email = \Email::forge('jis');
        $email->from("info@kinyu-joshi.jp", ''); //送り元
        $email->subject("[きんゆう女子。] お問合せ確認メール");
        $email->html_body(\View::forge('email/inquiry/body.smarty', []));
        $email->to($params['email']); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("info@kinyu-joshi.jp", ''); //送り元
        $email02->subject("[きんゆう女子。] お問合せがありました");
        $name = $params['name'];
        // $title = $params['title'];
        $category_code = $params['category_code'];
        $message = $params['message'];
        $email = $params['email'];
        $email02->html_body(\View::forge('email/inquiry/return',
            array('name' => $name,
                'title' => '',
                'category_code' => $category_code,
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
                \DB::expr('inquiries.*'),
                \DB::expr('(select count(*) from inquiry_reply_mails where inquiry_reply_mails.inquiry_code = inquiries.code) as reply_num')
            )
            ->from('inquiries')
            ->where('inquiries.disable', '=', 0)
            ->order_by('inquiries.created_at', 'desc')
            ->execute()
            ->as_array();
    }

    public static function findByCode($code)
    {
        return \DB::select(
                \DB::expr('inquiries.*')
            )
            ->from('inquiries')
            ->where('inquiries.code', '=', $code)
            ->where('inquiries.disable', '=', 0)
            ->execute()
            ->current();
    }
}
