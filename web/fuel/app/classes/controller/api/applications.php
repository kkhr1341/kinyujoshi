<?php

use \Model\Applications;
use \Model\Payment;
use \Model\Events;
use \Model\EventCoupons;

class Controller_Api_Applications extends Controller_Apibase
{
    public function action_delete()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }

        $code = \Input::post('code');

        $event_code = Applications::get_event_code_by_code($code);

        if (!Events::cancelable($event_code)) {
            $res = Applications::non_cancelable_cancel($code);
        } else {
            $res = Applications::cancelable_cancel($code);
        }
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

            // 割引金額
            $coupon = EventCoupons::getByEventCodeAndCouponCode($val->validated('event_code'), $val->validated('coupon_code'));

            // 与信
            \Config::load('payjp', true);
            $payment = new Payment(\Config::get('payjp.private_key'));
            $res = Applications::create(
                $payment,
                $val->validated('event_code'),
                $val->validated('cardselect'),
                $val->validated('name'),
                $val->validated('email'),
                $val->validated('token'),
                $coupon
            );
            if (is_string($res)) {
                return $this->error($res);
            }
            return $this->ok($res);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function action_force_delete()
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }

        $code = \Input::post('code');

        $event_code = Applications::get_event_code_by_code($code);

        $username = \Auth::get('username');

        if (!Events::cancelable($event_code)) {
            $res = Applications::non_cancelable_cancel($code, $username);
        } else {
            $res = Applications::cancelable_cancel($code, $username);
        }
        if (is_string($res)) {
            return $this->error($res);
        }
        return $this->ok($res);
    }
}
