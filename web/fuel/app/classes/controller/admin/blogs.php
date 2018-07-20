<?php

use \Model\Blogs;
use \Model\Sections;

class Controller_Admin_Blogs extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
        $this->data['all_blogs'] = Blogs::lists02();
        $this->data['pick_blogs'] = Blogs::listspick();

        if (in_array('admin', $this->data['roles'])) {
            $this->data['closed_blogs'] = Blogs::lists02(0);
        } else {
            $this->data['closed_blogs'] = Blogs::lists02(0, null, null, null, null, \Auth::get('username'));
        }

        $this->data['open_blogs'] = Blogs::lists02(1);
        $this->template->contents = View::forge('admin/blogs/index.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('blogs.read')) {
            throw new HttpNoAccessException;
        }
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
        $this->data['blogs'] = Blogs::getByCode('blogs', $code);
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/edit.smarty', $this->data);
    }
}
