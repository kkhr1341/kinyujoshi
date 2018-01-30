<?php
use \Model\Kuchikomi;

class Controller_Api_Kuchikomi extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Kuchikomi::create(\Input::all()));
    }
}
