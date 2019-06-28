<?php

use \Model\Blogs;
use \Model\UserBlogs;

class Controller_Api_Blogs extends Controller_Base
{

    public function get_index()
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

    public function get_detail($code)
    {
        $blog = Blogs::getByCodeWithProfile($code);
        return $this->ok($blog);
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
            $params = Blogs::create($val->validated());

            // ユーザー投稿ブログテーブルとブログテーブルを関連づける
            if ($user_blog_code = Input::post('user_blog_code', '')) {
                $blog_code = $params['code'];
                UserBlogs::relate_blogs($blog_code, $user_blog_code);
                UserBlogs::save(array(
                    'code' => $user_blog_code,
                    'status' => 1,
                ));
            }

            return $this->ok($params);
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
            $params = Blogs::save($val->validated());

            // ユーザー投稿ブログテーブルとブログテーブルを関連づける
            if ($user_blog_code = Input::post('user_blog_code', '')) {
                $blog_code = $params['code'];
                UserBlogs::relate_blogs($blog_code, $user_blog_code);
                UserBlogs::save(array(
                    'code' => $user_blog_code,
                    'status' => 1,
                ));
            }

            return $this->ok($params);
        } catch(Exception $e) {
            return $this->error($e->getMessage());
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
