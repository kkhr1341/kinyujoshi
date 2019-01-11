<?php

use \Model\Authors;

class Controller_Admin_Authors extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['authors'] = Authors::lists();

        $this->template->contents = View::forge('admin/authors/index.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/create.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
//        $this->data['blogs'] = Blogs::getByCode('blogs', $code);
//        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/edit.smarty', $this->data);
    }
}
