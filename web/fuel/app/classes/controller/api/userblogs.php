<?php

use \Model\Authors;
use \Model\Blogs;
use \Model\UserBlogs;

class Controller_Api_Userblogs extends Controller_Base
{
    public function action_create()
    {
        if (!Auth::has_access('userblogs.create')) {
            return $this->error('permission denied');
        }
        $username = Auth::get('username');

        $val = UserBlogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        if (!Authors::get_by_username($username)) {
            return $this->error("投稿者のプロフィールが登録されておりません。");
        }
        $params = $val->validated();
        try {
            return $this->ok(UserBlogs::create($params));
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('userblogs.edit')) {
            return $this->error('permission denied');
        }
        $username = Auth::get('username');

        $val = UserBlogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $params = $val->validated();

        if (!Authors::get_by_username($username)) {
            return $this->error("投稿者のプロフィールが登録されておりません。");
        }

        try {
            UserBlogs::save($params);
            return $this->ok();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function action_delete($code)
    {
        if (!Auth::has_access('userblogs.delete')) {
            return $this->error('permission denied');
        }
        try {
            $username = Auth::get('username');
            $blog = UserBlogs::getByCodeAndUserName($code, $username);
            if ($blog['blog_code'] == '') {
                UserBlogs::delete($code);
            } else {
                UserBlogs::save(array(
                    'code' => $code,
                    'status' => 4,
                ));
            }
            return $this->ok();
        } catch(Exception $e) {
            return $this->error("削除に失敗しました。");
        }
    }
}
