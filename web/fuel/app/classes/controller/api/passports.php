<?php

use \Model\Passports;

class Controller_Api_Passports extends Controller_Base
{

    public function action_create()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }
        $username = \Auth::get('username');
        $val = Passports::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $params = $val->validated();

        $res = Passports::save($params, $username);
        if (is_string($res)) {
            return $this->error($res);
        }

        return $this->ok();
    }
}