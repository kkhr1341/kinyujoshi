<?php

use \Model\Blogs;

class Controller_Api_Blogs extends Controller_Base
{
    public function action_create()
    {
        $val = Blogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Blogs::create($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        $val = Blogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Blogs::save($val->validated()));
        } catch(Exception $e) {
            var_dump($e->getMessage());
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        $this->ok(Blogs::delete(\Input::all()));
    }
}
