<?php

use \Model\Events;

class Controller_Admin_Top extends Controller_Adminbase
{

    public function action_index()
    {
        if (!Auth::has_access('analysis.read')) {
            throw new HttpNoAccessException;
        }
        $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
        $this->template->contents = View::forge('admin/top/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
    }
}
