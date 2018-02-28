<?php

use \Model\UserCreditCard;
use \Model\Payment;

class Controller_My_Account extends Controller_Mybase
{

    public function action_index()
    {
        \Config::load('payjp', true);
        $this->data['cards'] = $this->get_credit_cards(\Config::get('payjp.private_key'));
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/account/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロフィール';
        $this->template->title = 'アカウント情報｜きん女。マイページ';
    }

    /**
     * 登録カード取得
     */
    private function get_credit_cards($private_key)
    {
        if (!$username = \Auth::get('username')) {
            return array();
        }
        if (!$cardIds = UserCreditCard::lists($username)) {
        }
        $payment = new Payment($private_key);
        if (!$customer = $payment->getCustomer($username)) {
            return array();
        }
        $cards = array();
        foreach ($cardIds as $cardId) {
            if ($card = $payment->getCard($customer, $cardId)) {
                $cards[] = $card;
            }
        }
        return $cards;
    }
}
