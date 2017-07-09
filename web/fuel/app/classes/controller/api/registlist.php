<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Registlist;

class Controller_Api_Registlist extends Controller_Base
{

  public function action_save() {
    $this->ok(Registlist::save(\Input::all()));
  }

  public function action_delete() {
    $this->ok(Registlist::delete(\Input::all()));
  }


}
