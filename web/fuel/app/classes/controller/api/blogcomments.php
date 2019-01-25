<?php

use \Model\Blogcomments;

class Controller_Api_Blogcomments extends Controller_Base
{
    public function action_create()
    {
        $val = Blogcomments::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Blogcomments::create($val->validated(), \Auth::get('username')));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        $val = Blogcomments::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Blogcomments::save($val->validated(), \Auth::get('username')));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }
}
