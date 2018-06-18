<?php

use \Model\Applications;
use \Model\EventMails;
use \Model\EventRemindMailTemplate;

class Controller_Api_Eventbroadcastmails extends Controller_Apibase
{
    public function action_send()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            // 参加者に一斉送信
            $applications = Applications::get_applications_by_code(\Input::post('code'));
            foreach ($applications as $application) {
                EventRemindMailTemplate::send(
                    $application['email'],
                    \Input::post('subject'),
                    \Input::post('body'),
                    $application['name'],
                    \Input::post('code')
                );
                EventMails::create($application['code'], $application['email']);
            }

            // 運営にも一通同じ内容で送信
            EventRemindMailTemplate::send(
                'cs@kinyu-joshi.jp',
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

    public function action_testsend()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            EventRemindMailTemplate::send(
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
