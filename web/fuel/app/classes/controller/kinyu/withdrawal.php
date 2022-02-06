<?php

class Controller_Kinyu_Withdrawal extends Controller_Kinyubase
{

    public function action_complete()
    {
        $this->template->title = '退会完了｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
        $this->template->keyword = '退会,お金,投資,初心者,Paypay';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/withdrawal/complete.smarty', $this->data);
    }
}


