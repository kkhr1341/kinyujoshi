<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Needs;

class Controller_Api_Needs extends Controller_Base
{


	public function action_create() {
		
		$this->ok(Needs::create(\Input::all()));
	}


}
