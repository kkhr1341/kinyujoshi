<?php

use \Model\Payment;

class Controller_Api_Creditcards extends Controller_Base
{
    public function action_delete()
    {
        $params = \Input::all();

        // 与信
        \Config::load('payjp', true);

        $payment = new Payment(\Config::get('payjp.private_key'));
        if (!$username = \Auth::get('username')) {
            $this->error("削除に失敗しました。");
        }
        try {
            $db = \Database_Connection::instance();
            $db->start_transaction();

            $customer = $payment->getCustomer($username);
            $payment->removeCard($customer, $params['card_id']);
            $db->commit_transaction();
            $this->ok();
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            $this->error("削除に失敗しました。");
        }
    }
}
