<?php

use \Model\Login;

class Controller_Api_Auth extends Controller_Base
{
    /**
     * ログイン
     */
    public function action_login()
    {
        $val = Login::validate();
        if (!$val->run()) {
            $this->error('メールアドレスもしくはパスワードが違うようです。');
        }
        $params = $val->validated();
        if (!\Auth::login($params['email'], $params['password'])) {
            $this->error('メールアドレスもしくはパスワードが違うようです。');
        }
        $this->ok('success');
    }
}