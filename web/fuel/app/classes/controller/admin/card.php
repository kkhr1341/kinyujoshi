<?php

use \Model\Wp;

class Controller_Admin_Card extends Controller_Adminbase
{

    public function action_index()
    {

        $wp = new Wp();
        // カードの登録があれば、結びつける
        if (\Input::post('wptoken') != "") {
            $res = $wp->set_card(Auth::get('username'), \Input::post('wptoken'));
            Response::redirect("/admin/card");
            exit();
        }

        $customer = $wp->get_wpcustomer(Auth::get('username'));
        $active_card = [
            'exp_month' => @$customer->active_card->exp_month,
            'exp_year' => @$customer->active_card->exp_year,
            'last4' => @$customer->active_card->last4,
            'type' => @$customer->active_card->type,
            'name' => @$customer->active_card->name,
        ];
        $this->data['active_card'] = $active_card;

        $this->template->contents = View::forge('admin/card/index.smarty', $this->data);
        $this->template->description = 'マイページ・カード';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    }

}
