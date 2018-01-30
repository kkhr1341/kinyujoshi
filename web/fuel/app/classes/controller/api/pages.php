<?php
use \Model\Pages;

class Controller_Api_Pages extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Pages::create(\Input::all()));
    }

    public function action_save()
    {
        $this->ok(Pages::save(\Input::all()));
    }

    public function action_delete()
    {
        $this->ok(Pages::delete(\Input::all()));
    }
}
