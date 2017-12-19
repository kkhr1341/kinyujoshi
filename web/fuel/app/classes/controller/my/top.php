<?php

use \Model\Profiles;
use \Model\Tsubuyaki;

class Controller_My_Top extends Controller_Mybase
{

	public function action_index() {
		
		//phpinfo();
		if (Auth::has_access('news.admin')) {
      //$id = Auth::get('id');
      $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
      $this->template->contents = View::forge('my/index.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'マイページ｜きんゆう女子。';
      $this->template->description = 'マイページ・トップ';
		}
		else {
      $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
      $this->template->contents = View::forge('my/all.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'マイページ｜きんゆう女子。';
      $this->template->description = 'マイページ・トップ';
		}

	}
}
