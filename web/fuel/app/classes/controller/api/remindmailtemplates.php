<?php

use \Model\EventRemindMailTemplates;
use \Model\EventRemindMailTestSends;

class Controller_Api_Remindmailtemplates extends Controller_Apibase
{
    public function action_save()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        try {
            $val = EventRemindMailTemplates::validate();
            if (!$val->run()) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }
            return $this->ok(EventRemindMailTemplates::save($val->validated()));
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

            $val = EventRemindMailTestSends::validate();
            if (!$val->run()) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }

            EventRemindMailTestSends::send($val->validated('email'), $val->validated('subject'), $val->validated('body'), array(
                'event_title' => $val->validated('event_title'),
                'event_place' => $val->validated('event_place'),
                'name' => 'てすと太郎',
            ));
            return $this->ok();
        } catch (\Exception $e) {
            return $this->error('送信に失敗しました');
        }
    }
}
