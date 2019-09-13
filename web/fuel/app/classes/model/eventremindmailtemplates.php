<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventRemindMailTemplates extends Base
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
            \DB::delete('event_remind_mail_templates')->where('event_code', '=', $params['event_code'])->execute();
        } else {
            if(\DB::select()->from('event_remind_mail_templates')->where('event_code', $params['event_code'])->execute()->current()) {
                \DB::update('event_remind_mail_templates')
                    ->set(array(
                        'subject'    => $params['subject'],
                        'body'       => $params['body'],
                        'updated_at' => \DB::expr('now()'),
                    ))
                    ->where('event_code', '=', $params['event_code'])
                    ->execute();
            } else {
                \DB::insert('event_remind_mail_templates')
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
            ->from('event_remind_mail_templates')
            ->where('event_code', '=', $event_code)
            ->execute()
            ->current();
    }
}