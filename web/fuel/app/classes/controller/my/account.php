<?php

use \Model\UserCreditCard;
use \Model\Payment;
use \Model\Withdrawalreasons;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Account extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        \Config::load('payjp', true);
        $this->data['email'] = Auth::get('email');
        $this->data['cards'] = $this->get_credit_cards(\Config::get('payjp.private_key'));
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/account/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロフィール';
        $this->template->title = 'アカウント設定｜きん女。マイページ';
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }

    public function action_withdrawal()
    {
        $username = \Auth::get('username');
        $this->data['reasons'] = Withdrawalreasons::lists();
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/account/withdrawal.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '退会フォーム';
        $this->template->title = '退会フォーム｜きん女。マイページ';
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
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
