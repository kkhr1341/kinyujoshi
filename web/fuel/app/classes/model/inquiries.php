<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Inquiries extends Base
{

    public static function create($params)
    {

        $code = self::getNewCode('inquiries');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        $params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        \DB::insert('inquiries')->set($params)->execute();

        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject("[きんゆう女子。] お問合せ確認メール");
        $email->html_body(\View::forge('email/inquiry/body.smarty', []));
        $email->to($params['email']); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
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
        return \DB::select(\DB::expr('*'))
            ->from('inquiries')
            ->order_by('created_at', 'desc')
            ->execute()
            ->as_array();
    }

    public static function findByCode($code)
    {
        return \DB::select(\DB::expr('*'))
            ->from('inquiries')
            ->where('code', '=', $code)
            ->execute()
            ->current();
    }
}
