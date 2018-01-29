<?php

use \Model\Events;
use \Model\Sections;
use \Model\Applications;

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

	public function action_joshikailist() {
	
		// if (!Auth::has_access('events.admin')) {
		// 	\Auth::logout();
		// 	Response::redirect('/');
		// 	exit();
		// }
		$this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
		$this->data['events'] = Events::lists(1, 50, true);
		$this->data['sections'] = Sections::lists();
		$this->data['all_events'] = Events::lists02();
		$this->data['closed_events'] = Events::lists(0);
		$this->data['open_events'] = Events::lists(1);
		$this->data['applications'] = Applications::get_applications();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = '女子会リスト';
		$this->template->contents = View::forge('my/events/joshikailist.smarty', $this->data);
	}

	public function action_joshikaidetail($application_code) {
	
		// if (!Auth::has_access('events.admin')) {
		// 	\Auth::logout();
		// 	Response::redirect('/');
		// 	exit();
		// }

        $application = Applications::getByCode("applications", $application_code);
		$this->data['application_code'] = $application_code;
        $code = $application['event_code']; // event code
		$this->data['event'] = Events::getByCodeWithProfile($code);
		$this->data['event_row'] = Events::getByCode('events', $code);
		$this->template->urlcode = $this->data['event_row']['code'];

		$this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
		$this->data['events'] = Events::getByCode('events', $code);
		$this->data['sections'] = Sections::lists();
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = '女子会リスト';
		$this->template->contents = View::forge('my/events/joshikaidetail.smarty', $this->data);
	}

}
