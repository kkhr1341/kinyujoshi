<?php

use \Model\News;

class Controller_Api_News extends Controller_Apibase
{
    public function action_create()
    {
        if (!Auth::has_access('news.create')) {
            exit();
        }
        $val = News::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(News::create($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('news.edit')) {
            exit();
        }
        $val = News::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(News::save($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        if (!Auth::has_access('news.delete')) {
            exit();
        }
        return $this->ok(News::delete(\Input::all()));
    }
}
