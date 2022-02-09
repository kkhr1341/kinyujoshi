<?php

class Controller_Kinyu_Withdrawal extends Controller_Kinyubase
{

    public function action_complete()
    {
        $this->template->title = '退会完了｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
        $this->template->keyword = '退会,お金,投資,初心者,Paypay';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/withdrawal/complete.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
    }
}


