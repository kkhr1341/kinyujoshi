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
}
