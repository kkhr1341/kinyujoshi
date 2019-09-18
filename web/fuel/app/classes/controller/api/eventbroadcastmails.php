<?php

use \Model\Applications;
use \Model\EventMails;
use \Model\EventRemindMailTemplates;

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
            $applications = Applications::get_applications_by_code(\Input::post('code'));
            foreach ($applications as $application) {
                try {
                    EventRemindMailTemplates::send(
                        $application['email'],
                        \Input::post('subject'),
                        \Input::post('body'),
                        $application['name'],
                        \Input::post('code')
                    );
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

            // 運営にも一通同じ内容で送信
            EventRemindMailTemplates::send(
                'cs@kinyu-joshi.jp',
                \Input::post('subject'),
                \Input::post('body'),
                'てすと太郎',
                \Input::post('code')
            );

//            if($error_mails) {
//                EventRemindMailTemplates::notify($error_mails);
//            }

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
            EventRemindMailTemplates::send(
                Input::post('email'),
                \Input::post('subject'),
                \Input::post('body'),
                'てすと太郎',
                \Input::post('code')
            );
            return $this->ok();
        } catch (\Exception $e) {
            return $this->error('送信に失敗しました');
        }
    }
}
