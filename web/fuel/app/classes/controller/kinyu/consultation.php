<?php

class Controller_Kinyu_Consultation extends Controller_Kinyubase
{

    public function action_joshikai_policy()
    {
        $this->template->title = 'コミュニティ運営ポリシー｜きんゆう女子。';
        $this->template->description = "おかねについて、ゆるりとおしゃべり。身近な家計管理から世界経済、FinTech（フィンテック）、ライフスタイルまで幅広いきんゆうをテーマに女子会をしています。";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->today = date("Y年n月");
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/consultation/joshikai_policy.smarty', $this->data);
    }

}


