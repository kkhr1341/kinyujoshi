<?php

use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_Character extends Controller_Kinyubase
{

    public function action_index()
    {
        //$this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
        //$this->data['events'] = Events::lists(1, 100, true, 0);
        $this->template->title = 'きん女。キャラクター｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/character/index.smarty', $this->data);
    }
}