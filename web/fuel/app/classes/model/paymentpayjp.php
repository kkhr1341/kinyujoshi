<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class PaymentPayjp extends Base
{

    private $payment;

    /**
     * Payment constructor.
     */
    public function __construct(\Model\Payment\Payjp $payment)
    {
        $this->payment = $payment;
    }

    public function charge(
        $username,
        $name,
        $email,
        $token,
        $amount,
        $application_code,
        $cardselect='0'
    ) {
        if ($cardselect === '0') {
            if (!$new_customer = $this->getCustomer($username)) {
                $new_customer = $this->createCreditCustomer($username, $name, $email);
            } else {
                $new_customer = $this->updateCreditCustomer($username, $name, $email);
            }
            $new_card = $this->registNewCreditCard(
                $new_customer,
                $token,
                $username,
                $name
            );
            $charge = $this->paymentByNewCreditCard(
                $new_customer,
                $new_card,
                $amount,
                $application_code,
                $name,
                $email
            );
        } else {
            $customer = $this->updateCreditCustomer($username, $name, $email);
            $charge = $this->paymentByRegistCreditCard(
                $cardselect,
                $customer,
                $amount,
                $application_code,
                $name,
                $email
            );
        }
        // クレジット決済イベントデータ作成
        \DB::insert('application_credit_payments')->set(array(
            'application_code' => $application_code,
            'charge_id' => $charge->id,
            'created_at' => \DB::expr('now()'),
        ))->execute();
        return $charge;
    }

    /**
     * クレジットカード登録ユーザー情報登録
     *
     * @param \Model\Payment $payment
     * @param string         $username  ユーザーネーム
     * @param string         $name      名前
     * @param string         $email     メールアドレス
     * @return bool
     * @throws \Exception
     */
    public function createCreditCustomer(
        $username,
        $name,
        $email
    ) {
        return $this->payment->createCustomer($username, $name, $email);
    }

    /**
     * クレジットカード登録ユーザー情報取得
     *
     * @param string         $username  ユーザーネーム
     * @return bool
     * @throws \Exception
     */
    public function getCustomer($username) {
        return $this->payment->getCustomer($username);
    }

    public function getCard($username, $cardId) {
        if (!$customer = $this->getCustomer($username)) {
            return array();
        }
        return $this->payment->getCard($customer, $cardId);
    }

    public function cancel($chargeId) {
        return $this->payment->cancel($chargeId);
    }

    public function sale($chargeId)
    {
        return $this->payment->sale($chargeId);
    }

    /**
     * クレジットカード登録ユーザー情報更新
     *
     * @param \Model\Payment $payment
     * @param string         $username  ユーザーネーム
     * @param string         $name      名前
     * @param string         $email     メールアドレス
     * @return bool
     * @throws \Exception
     */
    public function updateCreditCustomer(
        $username,
        $name,
        $email
    ) {
        $customer = $this->payment->getCustomer($username);
        $this->payment->updateCustomer($customer, $name, $email);
        return $customer;
    }

    /**
     * 新規カードで決済
     *
     * @param \Payjp\Customer $customer
     * @param \Model\Payment  $payment
     * @param string          $token             決済トークン※新規登録時に必須。カード登録に使用
     * @param string          $username          ユーザーネーム
     * @param string          $name              名前
     * @return bool
     * @throws \Exception
     */
    public function registNewCreditCard(
        \Payjp\Customer $customer,
        $token,
        $username,
        $name
    )
    {
        $new_card = $this->payment->createCard($customer, $token, $name);
        // 登録カードリソースデータ作成（二回目にカードを使う用）
        \DB::insert('user_credit_cards')->set(array(
            'username' => $username,
            'card_id' => $new_card->id,
            'created_at' => \DB::expr('now()'),
        ))->execute();
        return $new_card;
    }

    /**
     * 新規カードで決済
     *
     * @param \Model\Payment     $payment
     * @param \Payjp\Customer    $customer
     * @param \Payjp\Card        $card
     * @param integer            $amount            金額
     * @param string             $application_code  申し込みコード
     * @param string             $name              名前
     * @param string             $email             メールアドレス
     * @return bool
     * @throws \Exception
     */
    public function paymentByNewCreditCard(
        \Payjp\Customer $customer,
        \Payjp\Card $card,
        $amount,
        $application_code,
        $name,
        $email
    ) {
        return $this->payment->chargeByNewCard(
            $amount,
            $customer,
            $card,
            $application_code,
            $name,
            $email
        );
    }

    /**
     * 登録カードで決済
     *
     * @param $cardselect        カードID
     * @param \Model\Payment     $payment
     * @param $username          ユーザーネーム
     * @param $amount            ユーザーネーム
     * @param $application_code  申し込みコード
     * @param $name              ふりがな
     * @param $email             メールアドレス
     * @return bool
     * @throws \Exception
     */
    public function paymentByRegistCreditCard(
        $cardselect,
        \Payjp\Customer $customer,
        $amount,
        $application_code,
        $name,
        $email
    ) {
        return $this->payment->chargeByRegistCard(
            $amount,
            $customer,
            $cardselect,
            $application_code,
            $name,
            $email
        );
    }
}
