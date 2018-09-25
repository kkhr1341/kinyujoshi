<?php

use \Model\Events;
use \Model\Sections;
use \Model\Applications;

class Controller_My_Passport extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::lists(1, 50, true, 1);
        $this->data['sections'] = Sections::lists();
        //$this->data['all_events'] = Events::lists02();
        //$this->data['closed_events'] = Events::lists(0);
        //$this->data['open_events'] = Events::lists(1);
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'パスポート｜きん女。マイページ';
        $this->template->title = 'パスポート｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/passport/index.smarty', $this->data);
    }

    // ラクサス|Laxus
    public function action_passport_laxus()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::lists(1, 50, true, 1);
        $this->data['sections'] = Sections::lists();
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'パスポート｜きん女。マイページ';
        $this->template->title = 'パスポート｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/passport/passport_laxus.smarty', $this->data);
    }




}
