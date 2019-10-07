<?php

class Controller_Kinyu_Consultation extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->template->title = '相談窓口｜きんゆう女子。';
        $this->template->description = "おかねについて、ゆるりとおしゃべり。身近な家計管理から世界経済、FinTech（フィンテック）、ライフスタイルまで幅広いきんゆうをテーマに女子会をしています。";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/consultation/index.smarty', $this->data);
    }

    public function action_joshikai_policy()
    {
        $this->template->title = 'きんゆう女子。が大事にしていること｜きんゆう女子。';
        $this->template->description = "おかねについて、ゆるりとおしゃべり。身近な家計管理から世界経済、FinTech（フィンテック）、ライフスタイルまで幅広いきんゆうをテーマに女子会をしています。";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/consultation/joshikai_policy.smarty', $this->data);
    }

    public function action_complete()
    {
        $this->template->title = '相談窓口完了ページ｜きんゆう女子。';
        $this->template->description = "おかねについて、ゆるりとおしゃべり。身近な家計管理から世界経済、FinTech（フィンテック）、ライフスタイルまで幅広いきんゆうをテーマに女子会をしています。";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        $this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/consultation/complete.smarty', $this->data);
    }
}


