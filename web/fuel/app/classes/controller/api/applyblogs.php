<?php

use \Model\Authors;
use \Model\Blogs;

class Controller_Api_Applyblogs extends Controller_Base
{
    public function action_create()
    {
        if (!Auth::has_access('blogs.create')) {
            return $this->error('permission denied');
        }
        $username = Auth::get('username');

        $val = Blogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        if (!$author = Authors::get_by_username($username)) {
            return $this->error("オーサーの登録がされておりません。");
        }
        $params = $val->validated();
        $params['author_code'] = $author['code'];
        try {
            return $this->ok(Blogs::create($params));
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function action_save()
    {
        if (!Auth::has_access('blogs.edit')) {
            return $this->error('permission denied');
        }
        $username = Auth::get('username');

        $val = Blogs::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        if (!$author = Authors::get_by_username($username)) {
            return $this->error("オーサーの登録がされておりません。");
        }
        $params = $val->validated();
        $params['author_code'] = $author['code'];

        try {
            Blogs::save($params);
            return $this->ok();
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        }
    }

    public function action_delete($code)
    {
        if (!Auth::has_access('blogs.delete')) {
            return $this->error('permission denied');
        }
        try {
            $blog = Blogs::getByCodeWithurl($code);
            if ($blog['status'] == 0) {
                Blogs::delete(array(
                    'code' => $code
                ));
            } else {
                Blogs::save(array(
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
