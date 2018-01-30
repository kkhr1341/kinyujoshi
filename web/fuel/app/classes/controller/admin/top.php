<?php

use \Model\Events;

class Controller_Admin_Top extends Controller_Adminbase
{

    public function action_index()
    {
        if (Auth::has_access('news.admin')) {
            //$id = Auth::get('id');
            $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
            $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
            $this->template->contents = View::forge('admin/index.smarty', $this->data);
            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
            $this->template->title = 'マイページ｜きんゆう女子。';
            $this->template->description = 'マイページ・トップ';
        } else {

            $this->data['events'] = Events::lists(1, 50, true, 'kinyu');
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->title = 'マイページ｜きんゆう女子。';
            $this->template->description = 'マイページ・トップ';
            $this->template->contents = View::forge('admin/all.smarty', $this->data);
            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        }
    }
}
