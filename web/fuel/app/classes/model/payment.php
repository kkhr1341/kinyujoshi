<?php

namespace Model;

//use Payjp\Payjp;

require_once(dirname(__FILE__)."/base.php");

class Payment extends Base {

    /**
     * Payment constructor.
     */
    public function __construct($apiKey)
    {
        \Payjp\Payjp::setApiKey($apiKey);
    }

    public function chargeByNewCard($fee, \Payjp\Customer $customer, \Payjp\Card $card, $application_code) {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'customer' => $customer,
            'card' => $card,
            'metadata' => array(
                'application_code' => $application_code
            )
        ));
    }

    public function chargeByRegistCard($fee, \Payjp\Customer $customer, $card, $application_code) {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'customer' => $customer,
            'card' => $card,
            'metadata' => array(
                'application_code' => $application_code
            )
        ));
    }

    public function chargeByToken($fee, $token, $application_code, $name, $email) {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'card' => $token,
            'metadata' => array(
                'name' => $name,
                'email' => $email,
                'application_code' => $application_code
            )
        ));
    }

    public function getCustomer($username) {
        try {
            return \Payjp\Customer::retrieve($username);
        } catch (\Payjp\Error\InvalidRequest $e) {
            return false;
        }
    }
    public function createCustomer($username) {
        try {
            return \Payjp\Customer::create(array(
                'id' => $username,
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("顧客情報の登録に失敗しました。");
        }
    }
    public function createCard(\Payjp\Customer $customer, $token) {
        try {
            return $customer->cards->create(array(
                'card' => $token
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("既にご登録のあるカードです。");
        }
    }
}
