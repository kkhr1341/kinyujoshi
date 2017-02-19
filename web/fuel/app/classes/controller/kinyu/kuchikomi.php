<?php

use \Model\Categories;

class Controller_Kinyu_Kuchikomi extends Controller_Kinyubase
{

  public function action_index() {
    $this->template->title = '勉強会リクエスト｜きんゆう女子。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-kuchikumi.jpg';
    $this->data['categories'] = Categories::lists();
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/kuchikomi/index.smarty', $this->data);
    $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でも口コミしてください！";

  }
  public function action_complete() {

    $this->template->title = '勉強会リクエスト｜きんゆう女子。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-kuchikumi.jpg';
    $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でも口コミしてください！";
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/kuchikomi/complete.smarty', $this->data);
  }
}