<?php

use \Model\EventRemindMailTemplate;

class Controller_Api_Remindmailtemplates extends Controller_Apibase
{
    public function action_save()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            $val = EventRemindMailTemplate::validate();
            if (!$val->run()) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }
            return $this->ok(EventRemindMailTemplate::save($val->validated()));
        } catch (\Exception $e) {
            return $this->error('登録に失敗しました');
        }
    }
    public function action_testmail()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            $event = Events::getByCode('events', \Input::post('event_code'));
            $this->send(Input::post('email'), \Input::post('subject'), \Input::post('body'), array(
                'event_title' => $event['title'],
                'event_place' => $event['place'],
                'name' => 'てすと太郎',
            ));
            return $this->ok();
        } catch (\Exception $e) {
            return $this->error('送信に失敗しました');
        }
    }
}
