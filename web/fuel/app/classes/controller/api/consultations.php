<?php

use \Model\Consultations;

class Controller_Api_Consultations extends Controller_Apibase
{
    public function post_create()
    {
        $val = Consultations::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            return $this->ok(Consultations::create($val->validated(), \Auth::get('username')));
        } catch(Exception $e) {
            var_dump($e->getMessage());
            return $this->error("お問い合わせに失敗しました。");
        }
    }
}
