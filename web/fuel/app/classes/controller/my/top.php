<?php

use \Model\Events;

class Controller_My_Top extends Controller_Mybase
{

    public function action_index()
    {
        $this->data['events'] = Events::lists(1, 50, true, 'kinyu');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        $this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}
