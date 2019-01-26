<?php

use \Model\Blogs;

class Controller_Api_Blogs extends Controller_Base
{

    public function action_index()
    {
        $kind = \Input::get('kind', '');
        $blogs = Blogs::fetch(array(
            'mode' => 1,
            'kind' => $kind,
            'open' => true,
            'limit' => 20,
        ));
        return $this->ok($blogs);
    }

    public function action_create()
    {
        if (!Auth::has_access('blogs.create')) {
            return $this->error('permission denied');
        }
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
        if (!Auth::has_access('blogs.edit')) {
            return $this->error('permission denied');
        }
        $val = Blogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Blogs::save($val->validated()));
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete()
    {
        if (!Auth::has_access('blogs.delete')) {
            return $this->error('permission denied');
        }
        $this->ok(Blogs::delete(\Input::all()));
    }
}
