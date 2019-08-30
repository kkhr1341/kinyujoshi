<?php

use \Model\Consultations;
use \Model\Consultationreplymails;

class Controller_Api_Consultationreplymails extends Controller_Apibase
{
    public function get_index($consultation_code)
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        return $this->ok(Consultationreplymails::lists($consultation_code));
    }
    public function post_send()
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        $val = Consultationreplymails::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }

        $inquiry = Consultations::findByCode($val->validated('code'));
        $email = $inquiry['email'];

        $username = \Auth::get('username');

        return $this->ok(Consultationreplymails::create($val->validated(), $email, $username));
    }
}
