<?php

use \Model\Inquiries;
use \Model\Inquiryreplymails;

class Controller_Api_Inquiryreplymails extends Controller_Apibase
{
    public function get_index($inquiry_code)
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        return $this->ok(Inquiryreplymails::lists($inquiry_code));
    }
    public function post_send()
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        $val = Inquiryreplymails::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }

        $inquiry = Inquiries::findByCode($val->validated('code'));
        $email = $inquiry['email'];

        $username = \Auth::get('username');

        return $this->ok(Inquiryreplymails::create($val->validated(), $email, $username));
    }
}
