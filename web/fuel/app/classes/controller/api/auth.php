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
            $this->error('メールアドレスもしくはパスワードが違うようです...。');
        }
        $params = $val->validated();
        if (!\Auth::login($params['email'], $params['password'])) {
            $this->error('メールアドレスもしくはパスワードが違うようです...。');
        }
        $this->ok(array(
            'after_login_url' => $this->get_redirect_url()
        ));
    }

    /**
     * ログイン・会員登録後のリダイレクト先URL取得
     * @return string
     */
    private function get_redirect_url()
    {
        if ($after_login_url = \Session::get('after_login_url')) {
            $url = $after_login_url;
        }
        else {
            $url = '/my';
        }
        \Session::set('after_login_url', '');
        \Session::set('referrer', '');

        return $url;
    }
}
