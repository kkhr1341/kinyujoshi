<?php

use \Model\Inquiries;

class Controller_Api_Inquiries extends Controller_Base
{
    public function action_create()
    {
        $this->ok(Inquiries::create(\Input::all()));
    }
}
