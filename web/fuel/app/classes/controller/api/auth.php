<?php
/**
 * The Auth Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Login;
use \Model\Register;

class Controller_Api_Auth extends Controller_Base
{
	public function action_login() {
        $val = Login::validate();
        if (!$val->run()) {
            $this->error('ログインに失敗しました');
        }
        $params = $val->validated();
        $res = \Auth::login($params['email'], $params['password']);
        if (!$res) {
            $this->error('ログインに失敗しました');
        }
        $this->ok('success');
	}

    public function action_regist() {
        $val = Register::validate();
        if (!$val->run()) {
            $this->error('登録に失敗しました');
        }
        try {
            $params = $val->validated();
            Auth::create_user(
                Str::random('alnum', 16),
                $params['password'],
                $params['email']
            );
            Auth::login($params['email'], $params['password']);
        } catch (Exception $e) {
            $this->error('登録に失敗しました');
        }
        $this->ok('success');
    }
}
