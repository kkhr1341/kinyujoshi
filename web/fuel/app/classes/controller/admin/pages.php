<?php

use \Model\Pages;
use \Model\Sections;

class Controller_Admin_Pages extends Controller_Adminbase
{

	public function action_index() {

		$this->data['sections'] = Sections::lists();
		$this->data['all_pages'] = Pages::lists();
		$this->data['closed_pages'] = Pages::lists(0);
		$this->data['open_pages'] = Pages::lists(1);
		$this->template->contents = View::forge('admin/pages/index.smarty', $this->data);
		$this->template->description = 'マイページ・ページ';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_create() {
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ページ';
		$this->template->contents = View::forge('admin/pages/create.smarty', $this->data);
	}

	public function action_edit($code) {
	
		$this->data['pages'] = Pages::getByCode('pages', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ページ';
		$this->template->contents = View::forge('admin/pages/edit.smarty', $this->data);
	}
}
