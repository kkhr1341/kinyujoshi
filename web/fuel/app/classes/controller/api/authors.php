<?php

use \Model\Authors;

class Controller_Api_Authors extends Controller_Base
{
    public function action_create()
    {
        if (!Auth::has_access('authors.create')) {
            return $this->error('permission denied');
        }
        $val = Authors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            $params = $val->validated();
            $params['username'] = \Auth::get('username');
            return $this->ok(Authors::create($params));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('authors.edit')) {
            return $this->error('permission denied');
        }
        $val = Authors::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            $params = $val->validated();

            if ($author = Authors::get_by_username(\Auth::get('username'))) {
                $params['code'] = $author['code'];
                return $this->ok(Authors::save($params));

            } else {
                $params['username'] = \Auth::get('username');
                return $this->ok(Authors::create($params));
            }
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        if (!Auth::has_access('authors.delete')) {
            return $this->error('permission denied');
        }
        $this->ok(Authors::delete(\Input::all()));
    }
}
