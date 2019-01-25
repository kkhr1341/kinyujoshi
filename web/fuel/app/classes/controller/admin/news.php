<?php

use \Model\News;
use \Model\Sections;

class Controller_Admin_News extends Controller_Adminbase
{
    public function action_index()
    {
        if (!Auth::has_access('news.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
        $this->data['all_news'] = News::lists();

        if (Auth::has_access('blogs.publish')) {
            $this->data['closed_news'] = News::lists(0);
        } else {
            $username = Auth::get('username');
            $this->data['closed_news'] = News::list_of_user(0, $username);
        }

        $this->data['open_news'] = News::lists(1);
        $this->template->contents = View::forge('admin/news/index.smarty', $this->data);
        $this->template->description = 'マイページ・ニュース';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('news.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ニュース';
        $this->template->contents = View::forge('admin/news/create.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('news.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['news'] = News::getByCode('news', $code);
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ニュース';
        $this->template->contents = View::forge('admin/news/edit.smarty', $this->data);
    }
}
