<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Regist;

class Controller_Api_Regist extends Controller_Apibase
{

    public function action_create()
    {
        $val = Regist::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $params = $val->validated();
        return $this->ok(Regist::create($params));
    }

    public function action_document()
    {
        return $this->ok(Regist::document(\Input::all()));
    }
}
