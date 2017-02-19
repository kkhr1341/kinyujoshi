<?php

use \Model\Applications;
use \Model\Sections;

class Controller_My_Applications extends Controller_Mybase
{

	public function action_index() {

		$this->data['sections'] = Sections::lists();
		$this->data['applications'] = Applications::get_applications();
// 		print_r($this->data);
    $this->template->description = 'マイページ・アプリケーション';
		$this->template->contents = View::forge('my/applications/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}
}
