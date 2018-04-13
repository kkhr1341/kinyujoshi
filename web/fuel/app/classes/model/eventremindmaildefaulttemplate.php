<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventRemindMailDefaultTemplate extends Base
{
    public static function getDefault()
    {
        return self::getById('event_remind_mail_default_templates', 1);
    }
}
