<?php

use \Model\Events;
use \Model\Sections;
use \Model\Applications;

class Controller_My_Mykinjo extends Controller_Mybase
{

		public function action_index()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::lists(1, 50, true);
        $this->data['sections'] = Sections::lists();
        $this->data['all_events'] = Events::lists02();
        $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1);
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->data['prev_applications'] = Applications::get_prev_events_applications($username);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->title = '参加予定の女子会｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/mykinjo/index.smarty', $this->data);
    }


}