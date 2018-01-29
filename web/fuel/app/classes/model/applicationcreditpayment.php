<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class ApplicationCreditPayment extends Base
{
    /**
     * 申し込みコードから決済IDを取得
     * @param $application_code 申し込みコード
     * @return string | bool
     */
    public static function getChargeIdByApplicationCode($application_code)
    {
        $data = \DB::select('charge_id')->from('application_credit_payments')
            ->where('application_code', '=', $application_code)
            ->execute()
            ->current();

        if (empty($data)) {
            return false;
        }

        return $data['charge_id'];
    }
}
