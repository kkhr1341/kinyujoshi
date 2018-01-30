<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Regist;

class Controller_Api_Regist extends Controller_Base
{

    public function action_create()
    {
        $val = Regist::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            $this->error($message);
        }
        $params = $val->validated();
        $this->ok(Regist::create($params));
    }

    public function action_document()
    {
        $this->ok(Regist::document(\Input::all()));
    }
}
