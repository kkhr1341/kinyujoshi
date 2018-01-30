<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Tsubuyaki;

class Controller_Api_Tsubuyaki extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Tsubuyaki::create(\Input::all()));
    }
}