<?php

use \Model\Events;
use \Model\Applications;

class Controller_My_Top extends Controller_Mybase
{

    public function action_index()
    {
        $this->data['applications'] = Applications::get_applications();
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        $this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }
}
