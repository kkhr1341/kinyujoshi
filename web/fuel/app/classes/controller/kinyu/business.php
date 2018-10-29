<?php

class Controller_Kinyu_Business extends Controller_Kinyubase
{
    public function action_index()
    {
        $this->template->title = 'きんゆう女子。コミュニティパートナーをご検討の企業様へ｜きんゆう女子。';
        $this->template->description = "";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/diagnosticchart/og-main.jpg';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/business/index.smarty', $this->data);
    }

}
