<?php

use \Model\EventDisplayTopPages;

class Controller_Api_Eventdisplaytoppages extends Controller_Apibase
{
    public function action_save()
    {
        if (!Auth::check()) {
            return $this->error('login');
        }
        return $this->ok(EventDisplayTopPages::save(\Input::post('code')));
    }
}
