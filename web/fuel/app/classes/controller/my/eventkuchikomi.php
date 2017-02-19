<?php

use \Model\Eventkuchikomi;
use \Model\Sections;

class Controller_My_Eventkuchikomi extends Controller_Mybase
{
  public function action_index() {
    $this->data['sections'] = Sections::lists();
    //$this->data['all_events'] = Eventkuchikomi::lists();
    $this->data['closed_events'] = Eventkuchikomi::lists02(0);
    $this->data['open_events'] = Eventkuchikomi::lists02(1);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・イベント';
    $this->template->contents = View::forge('my/eventkuchikomi/index.smarty', $this->data);
  }

  public function action_edit($code) {
    $this->data['eventkuchikomi'] = Eventkuchikomi::getByCode('event_kuchikomi', $code);
    $this->data['sections'] = Sections::lists();
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・イベント';
    $this->template->contents = View::forge('my/eventkuchikomi/edit.smarty', $this->data);
  }
}
