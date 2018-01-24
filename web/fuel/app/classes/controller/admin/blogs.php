<?php

use \Model\Blogs;
use \Model\Sections;

class Controller_Admin_Blogs extends Controller_Adminbase
{

	public function action_index() {

		$this->data['sections'] = Sections::lists();
		$this->data['all_blogs'] = Blogs::lists02();
		$this->data['pick_blogs'] = Blogs::listspick();
		$this->data['closed_blogs'] = Blogs::lists02(0);
		$this->data['open_blogs'] = Blogs::lists02(1);
		$this->template->contents = View::forge('admin/blogs/index.smarty', $this->data);
		$this->template->description = 'マイページ・ブログ';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_create() {
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ブログ';
		$this->template->contents = View::forge('admin/blogs/create.smarty', $this->data);
	}

	public function action_edit($code) {
	
		$this->data['blogs'] = Blogs::getByCode('blogs', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ブログ';
		$this->template->contents = View::forge('admin/blogs/edit.smarty', $this->data);
	}
}
