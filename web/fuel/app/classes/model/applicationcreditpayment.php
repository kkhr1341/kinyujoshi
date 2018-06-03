<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class ApplicationCreditPayment extends Base
{
    /**
     * 申し込みコードから決済IDを取得
     * @param $application_code 申し込みコード
     * @return string | bool
     */
    public static function getChargeIdByApplicationCode($application_code)
    {
        $data = \DB::select('charge_id')
            ->from('application_credit_payments')
            ->where('application_code', '=', $application_code)
            ->execute()
            ->current();

        if (empty($data)) {
            return false;
        }

        return $data['charge_id'];
    }
    
    public static function sale($application_code)
    {
        \Config::load('payjp', true);
        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
        
            $charge_id = ApplicationCreditPayment::getChargeIdByApplicationCode($application_code);

            // 決済データを売り上げ状態に変更
            \DB::update('application_credit_payments')->set(array(
                'sale' => 1,
                'updated_at' => \DB::expr('now()'),
            ))
                ->where('application_code', '=', $application_code)
                ->execute();

            // 決済売り上げデータ作成
            \DB::insert('application_credit_payment_sales')->set(array(
                'application_code' => $application_code,
                'created_at' => \DB::expr('now()'),
            ))->execute();

            $payment = new Payment(\Config::get('payjp.private_key'));
            $payment->sale($charge_id);

            $db->commit_transaction();

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $db->rollback_transaction();
            throw $e;
        }
    }
}
