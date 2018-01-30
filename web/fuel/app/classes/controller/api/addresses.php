<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Addresses;

class Controller_Api_Addresses extends Controller_Base
{

    public function action_create()
    {
        $this->ok(Addresses::create(\Input::all()));
    }

    public function action_save()
    {
        $this->ok(Addresses::save(\Input::all()));
    }

    public function action_delete()
    {
        $this->ok(Addresses::delete(\Input::all()));
    }
}
