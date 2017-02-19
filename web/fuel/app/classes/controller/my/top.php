<?php

use \Model\Profiles;
use \Model\Tsubuyaki;

class Controller_My_Top extends Controller_Mybase
{

	public function action_index() {
		
		//phpinfo();
		if (Auth::has_access('news.admin')) {
		}
		else {
		}

		if (Agent::is_smartphone()) { 
      $this->data['tsubuyaki'] = Tsubuyaki::lists(1, 5);
      $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
			$this->template->contents = View::forge('kinyu/mysp/index.smarty', $this->data);
			$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
			$this->template->title = 'マイページ｜きんゆう女子。';
    	$this->template->description = 'マイページ・トップ';
		} else {
 			//$id = Auth::get('id');
      $this->data['tsubuyaki'] = Tsubuyaki::lists(1, 5);
      $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
			$this->template->contents = View::forge('my/index.smarty', $this->data);
			$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    	$this->template->title = 'マイページ｜きんゆう女子。';
    	$this->template->description = 'マイページ・トップ';
    }
	}
}
