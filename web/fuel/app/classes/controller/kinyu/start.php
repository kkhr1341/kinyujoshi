<?php

class Controller_Kinyu_Start extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->template->title = 'はじめての方へ｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/myway/og_myway.jpg';
        $this->template->description = 'わたしたち、きんゆう女子。は、金融にむきあっていくうちに気づきました。豊かに生きるための第一歩は「自分を知ること」。このページでは、「わたしを知ること」をテーマに情報を発信していきます。';
        $this->template->keyword = 'はじめての方へ,お金,投資,初心者,貯金';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->about_contents_after = View::forge('kinyu/about/about_contents_after.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/start/index.smarty', $this->data);
    }
}