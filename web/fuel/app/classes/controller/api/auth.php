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
            $this->error('ログインに失敗しました');
        }
        $params = $val->validated();
        if (!\Auth::login($params['email'], $params['password'])) {
            $this->error('ログインに失敗しました');
        }
        $this->ok('success');
    }
}
