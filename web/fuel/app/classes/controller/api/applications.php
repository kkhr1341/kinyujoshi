<?php

use \Model\Applications;
use \Model\Payment;
use \Model\Events;

class Controller_Api_Applications extends Controller_Apibase
{
    public function action_delete()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }

        $application = Applications::getByCode('applications', \Input::post('code'));
        if (!Events::cancelable($application['event_code'])) {
            return $this->error('キャンセル期日をすぎておりますためキャンセルはご利用いただけません');
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
            if (!Events::applicable(\Input::post('event_code'))) {
                return $this->error('イベントの受付を終了いたしました。');
            }
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
