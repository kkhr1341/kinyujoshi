<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Kuchikomi;

class Controller_Api_Kuchikomi extends Controller_Base
{

  public function action_create() {
    
    $this->ok(Kuchikomi::create(\Input::all()));
  }


}
