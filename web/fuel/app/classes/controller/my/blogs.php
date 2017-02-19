<?php

use \Model\Blogs;
use \Model\Sections;

class Controller_My_Blogs extends Controller_Mybase
{

	public function action_index() {

		$this->data['sections'] = Sections::lists();
		$this->data['all_blogs'] = Blogs::lists02();
		$this->data['closed_blogs'] = Blogs::lists02(0);
		$this->data['open_blogs'] = Blogs::lists02(1);
		$this->template->contents = View::forge('my/blogs/index.smarty', $this->data);
		$this->template->description = 'マイページ・ブログ';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_create() {
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ブログ';
		$this->template->contents = View::forge('my/blogs/create.smarty', $this->data);
	}

	public function action_edit($code) {
	
		$this->data['blogs'] = Blogs::getByCode('blogs', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ブログ';
		$this->template->contents = View::forge('my/blogs/edit.smarty', $this->data);
	}
}
