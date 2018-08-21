<?php

use \Model\Blogstocks;

class Controller_My_Blog extends Controller_Mybase
{

    public function action_index()
    {
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['blogs'] = Blogstocks::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->title = '参加予定の女子会｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/blog/index.smarty', $this->data);
    }
}
