<?php


class Controller_Chat_Top extends Controller_Mybase
{

    public function action_index()
    {
//        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        $this->template->keyword = 'きんゆう女子,お金,投資,初心者,貯金';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

        $this->template->contents = View::forge('chat/index', $this->data);
    }
}
