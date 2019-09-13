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
            ->execute()
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
}