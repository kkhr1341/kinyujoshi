<?php

use \Model\Applications;
use \Model\Payment;

class Controller_Api_Applications extends Controller_Apibase
{
    public function action_delete()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }

        $res = Applications::cancel(\Input::all());
        if (is_string($res)) {
            return $this->error($res);
        }
        return $this->ok($res);
    }

    public function action_create()
    {
        try {
            $val = Applications::validate(\Input::post('cardselect'));
            if (!$val->run(\Input::post())) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }

            // 与信
            \Config::load('payjp', true);
            $payment = new Payment(\Config::get('payjp.private_key'));
            $res = Applications::create(
                $payment,
                $val->validated('event_code'),
                $val->validated('cardselect'),
                $val->validated('name'),
                $val->validated('email'),
                $val->validated('token')
            );
            if (is_string($res)) {
                return $this->error($res);
            }
            return $this->ok($res);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}