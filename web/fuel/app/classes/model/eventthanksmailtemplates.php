<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventThanksMailTemplates extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('event_code')
            ->add_rule('required');

        $val->add('subject');

        $val->add('body');

        return $val;
    }

    public static function save($params)
    {
        if (!$params['subject'] || !$params['body']) {
            \DB::delete('event_thanks_mail_templates')->where('event_code', '=', $params['event_code'])->execute();
        } else {
            if(\DB::select()->from('event_thanks_mail_templates')->where('event_code', $params['event_code'])->execute()->current()) {
                \DB::update('event_thanks_mail_templates')
                    ->set(array(
                        'subject'    => $params['subject'],
                        'body'       => $params['body'],
                        'updated_at' => \DB::expr('now()'),
                    ))
                    ->where('event_code', '=', $params['event_code'])
                    ->execute();
            } else {
                \DB::insert('event_thanks_mail_templates')
                    ->set(array(
                        'event_code' => $params['event_code'],
                        'subject'    => $params['subject'],
                        'body'       => $params['body'],
                        'created_at' => \DB::expr('now()'),
                    ))
                    ->execute();
            }
        }
        return $params;
    }

    public static function getByEventCode($event_code)
    {
        return \DB::select()
            ->from('event_thanks_mail_templates')
            ->where('event_code', '=', $event_code)
            ->execute('slave')
            ->current();
    }

    public static function send($mail, $name, $event_code)
    {
        $event = \DB::select()
            ->from('events')
            ->where('code', '=', $event_code)
            ->execute()
            ->current();

        $template = self::getByEventCode($event_code);

        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject($template['subject']);

        $body = $template['body'];


        $event_time = '';
        if ($event['event_start_datetime'] || $event['event_end_datetime']) {
            $event_time = $event['event_start_datetime'] . '〜' . $event['event_end_datetime'];
        }

        $options = array(
            'event_url'   => \Uri::base(false) . 'joshikai/' . $event['code'],
            'event_date'  => $event['display_event_date']  ? $event['display_event_date']: \Date::forge(strtotime($event['event_date']))->format("%Y/%m/%d", true) . ' ' . $event_time,
            'event_title' => $event['title'],
            'event_place' => $event['place'],
            'name'        => $name
        );

        foreach ($options as $key => $value) {
            $body = str_replace('{% ' . $key . ' %}', $value, $body);
        }

        $email->body($body);
        $email->to($mail); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();
    }


    /**
     * 女子会サンクスメールの件名の初期値取得
     * @return string
     */
    public static function getDefaultSubject()
    {
        return 'ご参加ありがとうございました♡';
    }

    /**
     * 女子会サンクスメールの本文の初期値取得
     * @return string
     */
    public static function getDefaultBody()
    {
        return '＊{% event_title %}に参加いただいたみなさんへ＊

こんにちは！
きんゆう女子。編集部です。

昨日は女子会にお越しいただきましてありがとうございました！
1つでも学びになることがありましたら嬉しいです。

今後もさまざまなイベントを開催していきますので
興味のあるイベントがありましたらぜひお越しくださいね。
https://kinyu-joshi.jp/joshikai

昨日の女子会の感想や、ご要望などありましたら
support@kinyu-joshi.jp までとお知らせくださいませ。

またお会いできる日を楽しみにしています。
引き続き、きんゆう女子。をよろしくお願いいたします。

*--*--*--*--*--*--*--*--*--*--*--*--*--*

きんゆう女子。編集部(support@kinyu-joshi.jp)

〒103-0025
東京都中央区日本橋茅場町1-5-8　東京証券会館　B-313
運営会社：株式会社TOE THE LINE

✧きんゆう女子。コミュニティ✧
『お金にとらわれず自由に等身大で生きる』
公式サイト：https://kinyu-joshi.jp/

✧Instagram✧@kinyu_joshi
✧Twitter✧@kinyu_joshi
✧Facebook✧きんゆう女子。
';
    }
}
