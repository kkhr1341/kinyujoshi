<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventRemindMailTemplate extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('event_code');

        $val->add('subject');

        $val->add('body');

        return $val;
    }

    public static function save($params)
    {
        if ($aa = self::getByEventCode($params['event_code'])) {
            $params['updated_at'] = \DB::expr('now()');
            \DB::update('event_remind_mail_templates')
                ->set($params)
                ->where('event_code', '=', $params['event_code'])
                ->execute();
        } else {
            $params['created_at'] = \DB::expr('now()');
            \DB::insert('event_remind_mail_templates')
                ->set($params)
                ->execute();
        }
        return $params;
    }

    public static function getByEventCode($event_code)
    {
        return \DB::select()
            ->from('event_remind_mail_templates')
            ->where('event_code', '=', $event_code)
            ->execute()
            ->current();
    }

    public static function send($mail, $subject, $body, $name, $event_code)
    {
        $event = Events::getByCode('events', $event_code);

        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject($subject);

        $options = array(
            'event_url' => \Uri::base(false) . 'joshikai/' . $event_code,
            'event_title' => $event['title'],
            'event_place' => $event['place'],
            'name' => $name,
        );

        foreach ($options as $key => $value) {
            $body = str_replace('{% ' . $key . ' %}', $value, $body);
        }

        $email->body($body);
        $email->to($mail); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();
    }

    public static function notify($error_mails)
    {
        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", '');
        $email->subject("メール一斉送信でエラーがありました");

        $body = 'エラーメール' . "\n";
        $body .= '件数（' . count($error_mails) . '）' . "\n";
        foreach($error_mails as $error_mail) {
            $body .= $error_mail. "\n";
        }

        $email->body($body);
        $email->to('cs@kinyu-joshi.jp');

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();
    }
}
