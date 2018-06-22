<?php

use \Model\Events;

class Controller_Api_Eventdisplaypast extends Controller_Apibase
{
    public function action_save()
    {
        if (!Auth::check()) {
            return $this->error('update display_past');
        }
        return $this->ok(Events::updateDisplayPast(\Input::post('code'), Input::post('display_past')));
    }
}
