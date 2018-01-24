<?php

use \Model\Addresses;

class Controller_Admin_Addresses extends Controller_Adminbase
{

	public function action_index() {

		$this->data['addresses'] = Addresses::lists(Auth::get('username'));
		$this->template->contents = View::forge('admin/addresses/index.smarty', $this->data);
		$this->template->description = 'マイページ・アドレス';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		
	}

	public function action_create() {
	
		$this->template->contents = View::forge('admin/addresses/create.smarty', $this->data);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・アドレス';
	}

	public function action_edit($code) {
	
		$this->data['address'] = Addresses::getByCode('addresses', $code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・アドレス';
		$this->template->contents = View::forge('admin/addresses/edit.smarty', $this->data);
	}

}
