<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventMails extends Base
{

    public static function create($application_code, $email)
    {
        \DB::insert('event_mails')->set(array(
            'application_code' => $application_code,
            'email' => $email,
            'created_at' => \DB::expr('now()'),
        ))->execute();
    }
}
