<?php

class Controller_My_Profile extends Controller_Mybase
{

    public function action_index()
    {
        $this->template->email = Auth::get('email');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/profile/index.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'プロフィール｜きん女。マイページ';
        $this->template->title = 'プロフィール｜きん女。マイページ';
    }

    public function action_edit()
    {
        $this->template->email = Auth::get('email');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->contents = View::forge('my/profile/edit.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'プロフィール編集｜きん女。マイページ';
        $this->template->title = 'プロフィール編集｜きん女。マイページ';
    }
}
