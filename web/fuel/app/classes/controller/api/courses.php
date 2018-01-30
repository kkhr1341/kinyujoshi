<?php

use \Model\Courses;

class Controller_Api_Courses extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Courses::create(\Input::all()));
    }

    public function action_save()
    {
        $this->ok(Courses::save(\Input::all()));
    }

    public function action_delete()
    {
        $this->ok(Courses::delete(\Input::all()));
    }
}
