<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

use \Model\Events;

class EventRemindMailTestSends extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('event_title');

        $val->add('event_place');

        $val->add('subject');

        $val->add('body');

        $val->add('email');

        return $val;
    }

    public static function send($mail, $subject, $body, $options=array())
    {
        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject($subject);

        $options = array(
            'event_title' => !isset($options['event_title']) ? '': $options['event_title'],
            'event_place' => !isset($options['event_place']) ? '': $options['event_place'],
            'name'        => !isset($options['name'])        ? '': $options['name'],
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
