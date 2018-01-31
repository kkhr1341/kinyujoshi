<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Registlist;

class Controller_Api_Registlist extends Controller_Apibase
{

    public function action_create()
    {
        return $this->ok(Registlist::create(\Input::all()));
    }

    public function action_save()
    {
        return $this->ok(Registlist::save(\Input::all()));
    }

    public function action_delete()
    {
        return $this->ok(Registlist::delete(\Input::all()));
    }
}
