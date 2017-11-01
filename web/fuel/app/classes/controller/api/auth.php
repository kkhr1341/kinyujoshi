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
    /**
     * ログイン
     */
	public function action_login() {
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

    /**
     * 会員登録
     */
    public function action_register() {
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
        } catch (SimpleUserUpdateException $e) {
            Log::error('register error::'.$e->getMessage());
            $this->error('登録に失敗しました');
        }
        $this->ok('success');
    }
}
