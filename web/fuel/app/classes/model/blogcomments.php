<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Blogcomments extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('blog_code');
        $val->add('message', 'コメント')
            ->add_rule('required');

        return $val;
    }

    public static function create($params, $username)
    {
        $params['username'] = $username;
        $params['created_at'] = \DB::expr('now()');

        \DB::insert('blog_comments')->set($params)->execute();

        // 関係者に送信通知メール
        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("【きんゆう女子。】編集部へのコメントがありました");
        $email02->html_body(\View::forge('email/blog_comment/return',
            array(
                'url' => \Uri::base(false) . 'report/' . $params['blog_code'],
                'message' => $params['message'],
            )));
        $email02->to('support@kinyu-joshi.jp'); //送り先
        $email02->return_path('support@kinyu-joshi.jp');
        $email02->send();

        return $params;
    }

    public static function save($params, $username)
    {
        $params['username'] = $username;
        \DB::update('blog_comments')->set($params)->where('code', '=', $params['code'])->execute();

        return $params;
    }

//    public static function delete($params)
//    {
//        \DB::delete('blog_comments')->where('code', '=', $params['code'])->execute();
//
//        return $params;
//    }
}
