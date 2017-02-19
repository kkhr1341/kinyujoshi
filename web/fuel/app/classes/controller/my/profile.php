<?php

use \Model\Profiles;

class Controller_My_Profile extends Controller_Mybase
{

	public function action_index() {
    $this->data['special'] = Profiles::lists(1, 100, true);
		$this->template->contents = View::forge('my/profile/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・プロフィール';
	}

	public function action_edit() {
		$this->template->contents = View::forge('my/profile/edit.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・プロフィール';
	}
}
