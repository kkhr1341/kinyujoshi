<?php

use \Model\Addresses;

class Controller_My_Addresses extends Controller_Mybase
{

	public function action_index() {

		$this->data['addresses'] = Addresses::lists(Auth::get('username'));
		$this->template->contents = View::forge('my/addresses/index.smarty', $this->data);
		$this->template->description = 'マイページ・アドレス';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		
	}

	public function action_create() {
	
		$this->template->contents = View::forge('my/addresses/create.smarty', $this->data);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・アドレス';
	}

	public function action_edit($code) {
	
		$this->data['address'] = Addresses::getByCode('addresses', $code);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・アドレス';
		$this->template->contents = View::forge('my/addresses/edit.smarty', $this->data);
	}

}
