<?php

use \Model\Payment\Payjp;

class Controller_Api_Creditcards extends Controller_Apibase
{
    public function action_delete()
    {
        $params = \Input::all();

        // 与信
        \Config::load('payjp', true);

        $payment = new Payjp(\Config::get('payjp.private_key'));
        if (!$username = \Auth::get('username')) {
            return $this->error("削除に失敗しました。");
        }
        try {
            $db = \Database_Connection::instance();
            $db->start_transaction();

            \DB::delete('user_credit_cards')
                ->where('card_id', '=', $params['card_id'])
                ->execute();

            $customer = $payment->getCustomer($username);
            $payment->removeCard($customer, $params['card_id']);
            $db->commit_transaction();
            return $this->ok();
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return $this->error("削除に失敗しました。");
        }
    }
}
