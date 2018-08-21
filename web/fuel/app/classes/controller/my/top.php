<?php

use \Model\Applications;
use \Model\Events;

class Controller_My_Top extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->kinjo_check = View::forge('my/common/kinjo_check.smarty', $this->data);

    }
}
