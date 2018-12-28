<?php

use \Model\Eventmemos;

class Controller_Api_Eventmemos extends Controller_Apibase
{
    public function action_update()
    {
        if (!Auth::has_access('events.edit')) {
            exit();
        }

        $val = Eventmemos::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }

        Eventmemos::save($val->validated(), \Auth::get('username'));
        return $this->ok();
    }
}
