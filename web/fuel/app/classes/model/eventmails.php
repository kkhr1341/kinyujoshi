<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventMails extends Base
{

    public static function sended($application_code, $email)
    {
        \DB::insert('event_mails')->set(array(
            'application_code' => $application_code,
            'email' => $email,
            'error' => 0,
            'created_at' => \DB::expr('now()'),
        ))->execute();
    }

    public static function send_error($application_code, $email)
    {
        \DB::insert('event_mails')->set(array(
            'application_code' => $application_code,
            'email' => $email,
            'error' => 1,
            'created_at' => \DB::expr('now()'),
        ))->execute();
    }
}
