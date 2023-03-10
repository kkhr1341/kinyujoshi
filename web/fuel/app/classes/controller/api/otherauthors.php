<?php

use \Model\Authors;

class Controller_Api_Otherauthors extends Controller_Base
{
    public function action_create()
    {
        if (!Auth::has_access('otherauthors.create')) {
            return $this->error('permission denied');
        }
        $val = Authors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Authors::create($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('otherauthors.edit')) {
            return $this->error('permission denied');
        }
        $val = Authors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Authors::save($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        if (!Auth::has_access('otherauthors.delete')) {
            return $this->error('permission denied');
        }
        $this->ok(Authors::delete(\Input::all()));
    }
}
