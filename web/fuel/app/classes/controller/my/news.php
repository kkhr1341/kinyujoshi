<?php

use \Model\News;
use \Model\Sections;

class Controller_My_News extends Controller_Mybase
{

	public function action_index() {
		
		if (!Auth::has_access('news.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}

		$this->data['sections'] = Sections::lists();
		$this->data['all_news'] = News::lists();
		$this->data['closed_news'] = News::lists(0);
		$this->data['open_news'] = News::lists(1);
		$this->template->contents = View::forge('my/news/index.smarty', $this->data);
		$this->template->description = 'マイページ・ニュース';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
	}

	public function action_create() {
	
		if (!Auth::has_access('news.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}
		
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ニュース';
		$this->template->contents = View::forge('my/news/create.smarty', $this->data);
	}

	public function action_edit($code) {
	
		if (!Auth::has_access('news.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}
	
		$this->data['news'] = News::getByCode('news', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・ニュース';
		$this->template->contents = View::forge('my/news/edit.smarty', $this->data);
	}
}
