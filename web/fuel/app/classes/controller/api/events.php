<?php

use \Model\Events;

class Controller_Api_Events extends Controller_Apibase
{
    public function action_create()
    {
        if (!Auth::has_access('events.create')) {
            exit();
        }
        $val = Events::validate(\Input::post('status'));
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Events::create($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        } 
    }

    public function action_save()
    {
        if (!Auth::has_access('events.edit')) {
            exit();
        }

        $val = Events::validate(\Input::post('status'));
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        return $this->ok(Events::save($val->validated()));
    }

    public function action_delete()
    {
        if (!Auth::has_access('events.delete')) {
            exit();
        }
        return $this->ok(Events::delete(\Input::all()));
    }
}
