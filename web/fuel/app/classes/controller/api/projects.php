<?php
use \Model\Projects;

class Controller_Api_Projects extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Projects::create(\Input::all()));
    }

    public function action_save()
    {
        $this->ok(Projects::save(\Input::all()));
    }

    public function action_delete()
    {
        $this->ok(Projects::delete(\Input::all()));
    }
}
