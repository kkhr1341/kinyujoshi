<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class EventCoupons extends Base
{

    /**
     * @param $coupon_code
     * @param $event_code
     * @param $discount
     * @return array
     */
    public static function create($coupon_code, $event_code, $discount)
    {
        $data = array();

        $code = self::getNewCode('event_coupons');

        $data['code'] = $code;
        $data['coupon_code'] = $coupon_code;
        $data['event_code'] = $event_code;
        $data['discount'] = $discount;
        $data['created_at'] = \DB::expr('now()');
        \DB::insert('event_coupons')->set($data)->execute();

        return $data;
    }

    /**
     * @param $event_coupon_code
     */
    public static function delete($event_coupon_code)
    {
        \DB::update('event_coupons')->set(array(
            'disable' => 1
        ))->where('code', '=', $event_coupon_code)->execute();
    }

    /**
     * @param $event_code
     */
    public static function deleteByEventCode($event_code)
    {
        \DB::update('event_coupons')->set(array(
            'disable' => 1
        ))->where('event_code', '=', $event_code)->execute();
    }

    /**
     * @param $event_coupon_code
     * @param $coupon_code
     * @param $discount
     * @return array
     */
    public static function save($event_coupon_code, $coupon_code, $discount)
    {
        $data = array();
        $data['coupon_code'] = $coupon_code;
        $data['discount'] = $discount;
        $data['disable'] = 0;
        $data['updated_at'] = \DB::expr('now()');

        \DB::update('event_coupons')->set($data)->where('code', '=', $event_coupon_code)->execute();

        return $data;
    }

    /**
     * @param $event_code
     * @return mixed
     */
    public static function getRowsByEventCode($event_code)
    {
        $total = \DB::select('*')
            ->from('event_coupons')
            ->where('disable', '=', 0)
            ->where('event_code', '=', $event_code);

        return $total->execute('slave')->as_array();
    }

    /**
     * @param $event_code
     * @param $coupon_code
     * @return mixed
     */
    public static function getByCouponCode($event_code, $coupon_code)
    {
        $total = \DB::select('*')
            ->from('event_coupons')
            ->where('event_code', '=', $event_code)
            ->where('coupon_code', '=', $coupon_code);

        return $total->execute('slave')->current();
    }

//    public static function getByEventCodeAndCouponCode($event_code, $coupon_code)
//    {
//        $total = \DB::select('*')
//            ->from('event_coupons')
//            ->where('disable', '=', 0)
//            ->where('coupon_code', '=', $coupon_code)
//            ->where('event_code', '=', $event_code);
//
//        return $total->execute()->current();
//    }

    /**
     * @param $event_code
     * @param $coupon_code
     * @return mixed
     */
    public static function getDiscount($event_code, $coupon_code)
    {
        $total = \DB::select('discount')
            ->from('event_coupons')
            ->where('disable', '=', 0)
            ->where('coupon_code', '=', $coupon_code)
            ->where('event_code', '=', $event_code);

        $data = $total->execute('slave')->current();
        return $data['discount'];
    }
}
