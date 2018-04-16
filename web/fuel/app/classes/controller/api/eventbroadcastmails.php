<?php

use \Model\Applications;
use \Model\Events;

class Controller_Api_Eventbroadcastmails extends Controller_Apibase
{
    public function action_send()
    {
        $event = Events::getByCode('events', \Input::post('code'));
        $applications = Applications::get_applications_by_code(\Input::post('code'));
        foreach ($applications as $application) {
            $this->send($application['email'], \Input::post('subject'), \Input::post('body'), array(
                'event_title' => $event['title'],
                'event_place' => $event['place'],
                'name' => $application['name'],
            ));
        }
        return $this->ok();
    }

    public function action_testsend()
    {
        $event = Events::getByCode('events', \Input::post('code'));
        $this->send(Input::post('email'), \Input::post('subject'), \Input::post('body'), array(
            'event_title' => $event['title'],
            'event_place' => $event['place'],
            'name' => 'てすと太郎',
        ));
        return $this->ok();
    }

    private function send($mail, $subject, $body, $options=array())
    {
        $email = \Email::forge('jis');
        $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email->subject($subject);

        foreach ($options as $key => $value) {
            $body = str_replace('{% ' . $key . ' %}', $value, $body);
        }

        $email->body($body);
        $email->to($mail); //送り先
        $email->send();
    }
}
