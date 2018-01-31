<?php

use \Model\Applications;
use \Model\Payment;

class Controller_Api_Applications extends Controller_Base
{
    public function action_delete()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            $this->ok('login');
        }

        $res = Applications::cancel(\Input::all());
        if (is_string($res)) {
            $this->error($res);
        }
        $this->ok($res);
    }

    public function action_create()
    {
        try {
            $params = \Input::all();

            // 新規カード登録 or 会員登録をせずに申し込みの場合は以下必須
            if ($params['cardselect'] === '0') {
                if (empty($params['name'])) {
                    $this->error("お名前（フルネーム）を入力してください");
                }
                if (empty($params['email'])) {
                    $this->error("メールアドレスを入力してください");
                }
                if (empty($params['token'])) {
                    $this->error("申し込みに失敗しました");
                }
            }

            // 与信
            \Config::load('payjp', true);

            $payment = new Payment(\Config::get('payjp.private_key'));

            // 新規カード決済時の決済トークン（カード登録用に使用）
            $token = isset($params['token']) ? $params['token'] : '';

            $res = Applications::create(
                $payment,
                $params['event_code'],
                $params['cardselect'],
                $params['name'],
                $params['email'],
                $token
            );
            if (is_string($res)) {
                $this->error($res);
            }
            $this->ok($res);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
