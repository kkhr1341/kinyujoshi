<?php

use \Model\Userwithdrawal;

class Controller_Api_Users extends Controller_Base
{
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