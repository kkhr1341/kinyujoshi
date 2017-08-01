<?php

use \Model\Events;
use \Model\Sections;

class Controller_My_Events extends Controller_Mybase
{

	public function action_index() {
		
		if (!Auth::has_access('events.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}

		$this->data['sections'] = Sections::lists();
		$this->data['all_events'] = Events::lists02();
		$this->data['closed_events'] = Events::lists(0);
		$this->data['open_events'] = Events::lists(1);
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・イベント';
		$this->template->contents = View::forge('my/events/index.smarty', $this->data);
	}

	public function action_create() {
	
		if (!Auth::has_access('events.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}
		
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・イベント';
		$this->template->contents = View::forge('my/events/create.smarty', $this->data);
	}

	public function action_edit($code) {
	
		if (!Auth::has_access('events.admin')) {
			\Auth::logout();
			Response::redirect('/');
			exit();
		}
	
		$this->data['events'] = Events::getByCode('events', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = 'マイページ・イベント';
		$this->template->contents = View::forge('my/events/edit.smarty', $this->data);
	}
}
