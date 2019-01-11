<?php

use \Model\Authors;

class Controller_Admin_Authors extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('authors.read')) {
            throw new HttpNoAccessException;
        }
        $params = Input::get();

        $this->data['authors'] = Authors::all('/admin/authors/?' . http_build_query($params), Input::get('page', 1), 'page', 30);

        $pagination = $this->data['authors']['pagination'];
        $this->data['pagination'] = $pagination::instance('mypagination');

        $this->template->contents = View::forge('admin/authors/index.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

    public function action_create()
    {
        if (!Auth::has_access('authors.read')) {
            throw new HttpNoAccessException;
        }
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/authors/create.smarty', $this->data);
    }

    public function action_edit($code)
    {
        if (!Auth::has_access('authors.read')) {
            throw new HttpNoAccessException;
        }
        $this->data['author'] = Authors::getByCode('authors', $code);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・ブログ';
        $this->template->contents = View::forge('admin/authors/edit.smarty', $this->data);
    }
}
