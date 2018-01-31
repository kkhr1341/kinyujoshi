<?php

use \Model\Inquiries;

class Controller_Api_Inquiries extends Controller_Apibase
{
    public function action_create()
    {
        return $this->ok(Inquiries::create(\Input::all()));
    }
}
