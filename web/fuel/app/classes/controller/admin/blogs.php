<?php

use \Model\Blogs;
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
        $this->data['apply_blogs'] = Blogs::lists02(2, null, null, null, null, null, true);
        $this->data['update_blogs'] = Blogs::lists02(3, null, null, null, null, null, true);
        $this->data['delete_blogs'] = Blogs::lists02(4, null, null, null, null, null, true);
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
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/blogs/edit.smarty', $this->data);
    }
}
