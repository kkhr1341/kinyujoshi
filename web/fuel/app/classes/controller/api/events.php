<?php

use \Model\Events;
use \Model\EventCoupons;

class Controller_Api_Events extends Controller_Apibase
{
    public function action_create()
    {
        if (!Auth::has_access('events.create')) {
            exit();
        }
        $val = Events::validate(\Input::post('status'));
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }
        try {
            $event = Events::create($val->validated());
            if ($val->validated('coupon_code')) {
                EventCoupons::create(
                    $val->validated('coupon_code'),
                    $event['code'],
                    $val->validated('discount')
                );
            }

            return $this->ok($event);
        } catch(Exception $e) {
            return $this->error("保存に失敗しました。");
        } 
    }

    public function action_save()
    {
        if (!Auth::has_access('events.edit')) {
            exit();
        }

        $val = Events::validate(\Input::post('status'));
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }

        // 将来的に複数登録できるようにしたいが今はとりあえず1個だけしか登録できない仕様
        $coupons = EventCoupons::getRowsByEventCode($val->validated('code'));
        $coupon = $coupons ? $coupons[0]: '';

        Events::save($val->validated());
        if ($coupon) {
            if ($val->validated('coupon_code')) {
                EventCoupons::save(
                    $coupon['code'],
                    $val->validated('coupon_code'),
                    $val->validated('discount')
                );
            } else {
                EventCoupons::delete($coupon['code']);
            }
        } elseif($val->validated('coupon_code')) {
            EventCoupons::create(
                $val->validated('coupon_code'),
                $val->validated('code'),
                $val->validated('discount')
            );
        }

        return $this->ok();
    }

    public function action_delete()
    {
        if (!Auth::has_access('events.delete')) {
            exit();
        }
        return $this->ok(Events::delete(\Input::all()));
    }
}
