<?php

class Controller_Kinyu_Withcorporate extends Controller_Kinyubase
{

    public function action_paypay()
    {
        $this->template->title = 'Say Farewell to Cash';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-cashless.png';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';

        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        } else {
        }
        $this->template->contents = View::forge('kinyu/withcorporate/paypay.smarty', $this->data);
    }
}
