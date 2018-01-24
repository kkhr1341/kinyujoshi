<?php

use \Model\Profiles;

class Controller_Admin_Profile extends Controller_Adminbase
{

	public function action_index() {
    //$this->data['special'] = Profiles::lists(1, 100, true);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
		$this->template->contents = View::forge('admin/profile/index.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・プロフィール';
	}

	public function action_edit() {
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
		$this->template->contents = View::forge('admin/profile/edit.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'マイページ・プロフィール';
	}
}
