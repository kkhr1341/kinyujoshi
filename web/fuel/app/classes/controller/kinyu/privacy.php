<?php

use \Model\Privacies;

class Controller_Kinyu_Privacy extends Controller_Kinyubase
{

	public function action_index() {

		$this->data['privacy'] = Privacies::get();
		$this->template->title = 'プライバシーポリシー｜きんゆう女子。';
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/privacy/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}
}
