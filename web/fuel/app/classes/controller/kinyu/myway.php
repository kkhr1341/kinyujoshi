<?php

class Controller_Kinyu_Myway extends Controller_Kinyubase
{

    public function action_index()
    {
        $this->template->title = '「わたし」を知る。｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/myway/og_myway.jpg';
        $this->template->description = 'わたしたち、きんゆう女子。は、金融にむきあっていくうちに気づきました。豊かに生きるための第一歩は「自分を知ること」。このページでは、「わたしを知ること」をテーマに情報を発信していきます。';
        $this->template->keyword = '記事,私を知る,お金,投資,初心者';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/myway/index.smarty', $this->data);
    }
}