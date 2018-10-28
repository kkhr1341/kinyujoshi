<?php

use \Model\Events;
use \Model\EventCoupons;

class Controller_Api_Eventcoupons extends Controller_Apibase
{

    public function action_detail()
    {
        if (!$event_code = \Input::get('event_code')) {
            return $this->error('invalid argument');
        }
        if (!$coupon_code = \Input::get('coupon_code')) {
            return $this->error('invalid argument');
        }
        $discount = EventCoupons::getDiscount(
            $event_code,
            $coupon_code
        );
        if ($discount) {
            $event = Events::getByCode('events', $event_code);
            return $this->ok(array(
                'amount' => intval($event['fee']) - intval($discount),
                'fee' => intval($event['fee']),
                'discount' => intval($discount)
            ));

        } else {
            return $this->error('invalid coupon code');
        }
    }
}
