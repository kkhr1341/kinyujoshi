<?php

use \Model\Applications;
use \Model\EventMails;
use \Model\Events;

class Controller_Api_Eventbroadcastmails extends Controller_Apibase
{
    public function action_send()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {

            $error_mails = array();

            // 参加者に一斉送信
            $event = Events::getByCode('events', \Input::post('code'));
            $applications = Applications::get_applications_by_code(\Input::post('code'));
            foreach ($applications as $application) {
                try {
                    $this->send($application['email'], \Input::post('subject'), \Input::post('body'), array(
                        'event_title' => $event['title'],
                        'event_place' => $event['place'],
                        'event_url' => $event['code'] ? \Uri::base(false) . 'joshikai/' . $event['code'] : '',
                        'name' => $application['name'],
                    ));
                    EventMails::sended($application['code'], $application['email']);
                }
                catch(\EmailValidationFailedException $e)
                {
                    array_push($error_mails, $application['email']);
                    EventMails::send_error($application['code'], $application['email']);
                }
                catch(\EmailSendingFailedException $e)
                {
                    array_push($error_mails, $application['email']);
                    EventMails::send_error($application['code'], $application['email']);
                }
            }

            $this->send('cs@kinyu-joshi.jp', \Input::post('subject'), \Input::post('body'), array(
                'event_title' => $event['title'],
                'event_place' => $event['place'],
                'event_url' => $event['code'] ? \Uri::base(false) . 'joshikai/' . $event['code'] : '',
                'name' => 'てすと太郎',
            ));

            return $this->ok();
        } catch (\Exception $e) {
            return $this->error('送信に失敗しました');
        }
    }

    public function action_testsend()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            $event = Events::getByCode('events', \Input::post('code'));
            $this->send(Input::post('email'), \Input::post('subject'), \Input::post('body'), array(
                'event_title' => $event['title'],
                'event_place' => $event['place'],
                'event_url' => $event['code'] ? \Uri::base(false) . 'joshikai/' . $event['code'] : '',
                'name' => 'てすと太郎',
            ));
            return $this->ok();
        } catch (\Exception $e) {
            return $this->error('送信に失敗しました');
        }
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
