<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Blogs;

class Controller_Api_Blogs extends Controller_Base
{


	public function action_create() {
		$this->ok(Blogs::create(\Input::all()));
	}
	public function action_save() {
		$this->ok(Blogs::save(\Input::all()));
	}
	public function action_delete() {
		$this->ok(Blogs::delete(\Input::all()));
	}


}
