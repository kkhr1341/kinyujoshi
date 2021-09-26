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

            // 女子会クーポン保存
            foreach ($val->validated('coupons') as $coupon) {
                if ($coupon['coupon_code']) {
                    EventCoupons::create(
                        $coupon['coupon_code'],
                        $event['code'],
                        $coupon['discount']
                    );
                }
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

        try {
            Events::save($val->validated());

            // 女子会クーポンリセット

            // 将来的に複数登録できるようにしたいが今はとりあえず1個だけしか登録できない仕様
            EventCoupons::deleteByEventCode($val->validated('code'));

            foreach ($val->validated('coupons') as $coupon) {
                if ($coupon['coupon_code']) {
                    $a = EventCoupons::getByCouponCode($coupon['coupon_code']);
                    if ($a) {
                        EventCoupons::save(
                            $a['code'],
                            $coupon['coupon_code'],
                            $coupon['discount']
                        );
                    } else {
                        EventCoupons::create(
                            $coupon['coupon_code'],
                            $val->validated('code'),
                            $coupon['discount']
                        );
                    }
                }
            }

            return $this->ok();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

        public function action_delete()
    {
        if (!Auth::has_access('events.delete')) {
            exit();
        }
        return $this->ok(Events::delete(\Input::all()));
    }
}
