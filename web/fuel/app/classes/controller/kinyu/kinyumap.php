<?php

use \Model\Companies;

class Controller_Kinyu_Kinyumap extends Controller_Kinyubase
{

    // 会社概要
    public function action_ooedo_ito()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = '運営会社｜きんゆう女子。';
        $this->template->description = 'きんゆう女子。は、株式会社TOE THE LINEが運営しています。きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/kinyumap/ooedo_ito.smarty', $this->data);
    }

}