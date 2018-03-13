<?php

namespace Model;

require_once(dirname(__FILE__) . "/base.php");

class Payment extends Base
{

    /**
     * Payment constructor.
     */
    public function __construct($apiKey)
    {
        \Payjp\Payjp::setApiKey($apiKey);
    }

    /**
     * @param $fee
     * @param \Payjp\Customer $customer
     * @param \Payjp\Card $card
     * @param $application_code
     * @param $name
     * @param $email
     * @return \Payjp\Charge
     */
    public function chargeByNewCard($fee, \Payjp\Customer $customer, \Payjp\Card $card, $application_code, $name, $email)
    {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'customer' => $customer,
            'card' => $card,
            'expiry_days' => 60,
            'metadata' => array(
                'application_code' => $application_code,
                'username' => $customer->id,
                'name' => $name,
                'email' => $email,
            )
        ));
    }

    /**
     * @param $fee
     * @param \Payjp\Customer $customer
     * @param $card
     * @param $application_code
     * @param $name
     * @param $email
     * @return \Payjp\Charge
     */
    public function chargeByRegistCard($fee, \Payjp\Customer $customer, $card, $application_code, $name, $email)
    {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'customer' => $customer,
            'card' => $card,
            'expiry_days' => 60,
            'metadata' => array(
                'application_code' => $application_code,
                'username' => $customer->id,
                'name' => $name,
                'email' => $email,
            )
        ));
    }

    /**
     * @param $fee
     * @param $token
     * @param $application_code
     * @param $name
     * @param $email
     * @return \Payjp\Charge
     */
    public function chargeByToken($fee, $token, $application_code, $name, $email)
    {
        return \Payjp\Charge::create(array(
            'amount' => $fee,
            'currency' => 'jpy',
            'capture' => false,
            'card' => $token,
            'expiry_days' => 60,
            'metadata' => array(
                'application_code' => $application_code,
                'username' => 'guest',
                'name' => $name,
                'email' => $email,
            )
        ));
    }

    /**
     * 決済取り消し
     * @param $charge_id 決済ID
     */
    public function cancel($charge_id)
    {
        $charge = \Payjp\Charge::retrieve($charge_id);
        $charge->refund();
    }

    /**
     * 登録カード削除
     * @param $customer \Payjp\Customer
     * @param $card_id  登録カードID
     */
    public function removeCard(\Payjp\Customer $customer, $card_id)
    {
        $card = $customer->cards->retrieve($card_id);
        $card->delete();
    }

    /**
     * @param $username
     * @return bool|\Payjp\Customer
     */
    public function getCustomer($username)
    {
        try {
            return \Payjp\Customer::retrieve($username);
        } catch (\Payjp\Error\InvalidRequest $e) {
            return false;
        }
    }
    
    /**
     * @param $username
     * @return bool|\Payjp\Customer
     */
    public function sale($charge_id)
    {
        try {
            $ch = \Payjp\Charge::retrieve($charge_id);
            return $ch->capture();
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("売上処理に失敗しました。");
        }
    }

    /**
     * @param $username
     * @return \Payjp\Customer
     * @throws \Exception
     */
    public function createCustomer($username, $name, $email)
    {
        try {
            return \Payjp\Customer::create(array(
                'id' => $username,
                'email' => $email,
                'metadata' => array(
                    'name' => $name,
                )
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("顧客情報の登録に失敗しました。");
        }
    }

    /**
     * @param $username
     * @return \Payjp\Customer
     * @throws \Exception
     */
    public function updateCustomer($customer, $name, $email)
    {
        try {
            $customer->email = $email;
            $customer->metadata->name = $name;
            $customer->save();
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("顧客情報の登録に失敗しました。");
        }
    }

    /**
     * @param \Payjp\Customer $customer
     * @param $token
     * @param $name
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public function createCard(\Payjp\Customer $customer, $token, $name)
    {
        try {
            return $customer->cards->create(array(
                'card' => $token,
            ));
        } catch (\Payjp\Error\InvalidRequest $e) {
            throw new \Exception("既にご登録のあるカードです。");
        }
    }

    /**
     * @param \Payjp\Customer $customer
     * @param $card_id
     * @return mixed
     * @throws \Exception
     */
    public function getCard(\Payjp\Customer $customer, $card_id)
    {
        try {
            $card = $customer->cards->retrieve($card_id);
            // 下3桁 311 (MARIKO SUZUKI) 有効期限 20/11
            $format = '下4桁 %d (%s) 有効期限 %d/%d';
            return array(
                "id" => $card_id,
                "label" => sprintf($format, $card->last4, $card->name, $card->exp_month, $card->exp_year),
            );
        } catch (\Payjp\Error\InvalidRequest $e) {
            return false;
        }
    }
}
