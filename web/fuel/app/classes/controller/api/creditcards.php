<?php

use \Model\Payment;

class Controller_Api_Creditcards extends Controller_Base
{
    public function action_delete()
    {
        try {
            $params = \Input::all();

            // 与信
            \Config::load('payjp', true);

            $payment = new Payment(\Config::get('payjp.private_key'));
            if ($username = \Auth::get('username')) {
                $customer = $payment->getCustomer($username);
                $payment->removeCard($customer, $params['card_id']);
                $this->ok();
            }

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
