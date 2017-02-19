<?php

use \Model\Events;
use \Model\Applications;

class Controller_Api_Events extends Controller_Base
{


	public function action_create() {
		if (!Auth::has_access('events.admin')) {
			exit();
		}
		$this->ok(Events::create(\Input::all()));
	}
	public function action_save() {
		if (!Auth::has_access('events.admin')) {
			exit();
		}
		$this->ok(Events::save(\Input::all()));
	}
	public function action_delete() {
		if (!Auth::has_access('events.admin')) {
			exit();
		}
		$this->ok(Events::delete(\Input::all()));
	}
	
	public function action_cancel() {

		if (!Auth::check()) {
			\Session::set('referrer', \Input::referrer());
			$this->ok('login');
		}

		$res = Applications::cancel(\Input::all());
		if (is_string($res)) {
			$this->error($res);
		}
		$this->ok($res);
		
	}
	
	public function action_application() {
		
		if (!Auth::check()) {
			\Session::set('referrer', \Input::referrer());
			$this->ok('login');
		}
		
		$res = Applications::create(\Input::all());
		if (is_string($res)) {
			$this->error($res);
		}
		$this->ok($res);
	}


}
