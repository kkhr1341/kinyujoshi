<?php

use \Model\BlogAuthors;

class Controller_Api_BlogAuthors extends Controller_Base
{
    public function action_create()
    {
        if (!Auth::has_access('blogauthors.create')) {
            return $this->error('permission denied');
        }
        $val = BlogAuthors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(BlogAuthors::create($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('blogauthors.edit')) {
            return $this->error('permission denied');
        }
        $val = BlogAuthors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(BlogAuthors::save($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        if (!Auth::has_access('blogauthors.delete')) {
            return $this->error('permission denied');
        }
        $this->ok(BlogAuthors::delete(\Input::all()));
    }
}
