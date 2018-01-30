<?php

use \Model\Eventkuchikomi;

class Controller_Api_Eventkuchikomi extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Eventkuchikomi::create(\Input::all()));
    }

    public function action_save()
    {
        $this->ok(Eventkuchikomi::save(\Input::all()));
    }

    public function action_delete()
    {
        $this->ok(Eventkuchikomi::delete(\Input::all()));
    }
}