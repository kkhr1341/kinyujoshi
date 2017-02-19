<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Regist;

class Controller_Api_Regist extends Controller_Base
{


  public function action_create() {
    
    $this->ok(Regist::create(\Input::all()));
  }


}
