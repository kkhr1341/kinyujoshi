<?php

use \Model\User;
use \Model\Userwithdrawal;

class Controller_Api_Users extends Controller_Base
{

    public function action_save()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }
        $val = User::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $params = $val->validated();
        $res = User::save($params);
        if (is_string($res)) {
            return $this->error($res);
        }

        return $this->ok();
    }

    /**
     * ログイン
     */
    public function action_withdrawal()
    {
        $val = Userwithdrawal::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        $username = Auth::get('username');
        Userwithdrawal::withdrawal(
            $username,
            $val->validated('message'),
            $val->validated('withdrawal_reasons')
        );
        $this->ok('success');
    }
}