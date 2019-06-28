<?php

use \Model\Blogs;
use \Model\UserBlogs;
use \Model\Sections;
use \Model\Authors;

class Controller_Admin_Blogs extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
        $this->data['pick_blogs'] = Blogs::listspick(null, null, null, null, null, true);
        $this->data['closed_blogs'] = Blogs::lists02(0, null, null, null, null, null, true);
        $this->data['open_blogs'] = Blogs::lists02(1, null, null, null, null, null, true);

        $this->data['apply_blogs'] = UserBlogs::applying_lists();
        $this->data['update_blogs'] = UserBlogs::apply_update_lists();
        $this->data['delete_blogs'] = UserBlogs::apply_delete_lists();

        $this->data['all_blogs'] = Blogs::lists02(null, null, null, null, null, null, true);
        $this->template->contents = View::forge('admin/blogs/index.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }

        // ユーザー投稿内容で投稿情報を上書き
        if ($user_blog_code = Input::get('user_blog_code', '')) {
            $user_blog = UserBlogs::findByCode($user_blog_code);
            $this->data['blogs'] = array(
                'title' => $user_blog['title'],
                'content' => $user_blog['content'],
                'main_image' => $user_blog['main_image'],
                'author_code' => $user_blog['author_code'],
                'user_blog_code' => $user_blog_code,
            );
        }

        $this->data['authors'] = Authors::lists();
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/create.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['authors'] = Authors::lists();

        $this->data['blogs'] = Blogs::getByCode('blogs', $code);

        // ユーザー投稿内容で投稿情報を上書き
        if ($user_blog_code = Input::get('user_blog_code', '')) {
            $user_blog = UserBlogs::findByCode($user_blog_code);
            $this->data['blogs']['title'] = $user_blog['title'];
            $this->data['blogs']['content'] = $user_blog['content'];
            $this->data['blogs']['main_image'] = $user_blog['main_image'];
            $this->data['blogs']['author_code'] = $user_blog['author_code'];
            $this->data['blogs']['user_blog_code'] = $user_blog_code;
        }

        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/edit.smarty', $this->data);
    }
}
