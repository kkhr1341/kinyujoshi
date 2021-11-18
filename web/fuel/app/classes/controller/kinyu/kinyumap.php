<?php

use \Model\Companies;

class Controller_Kinyu_Kinyumap extends Controller_Kinyubase
{
    public function action_index()
    {
        $this->template->title = 'きんゆう散歩｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu_map/og/og-main.jpg';
        $this->template->description = '金融や経済ってあまり目に見えないけれど、実は身の回りには金融・経済に関わることがたくさん。ゆるりと旅する感覚で、金融を見たり、触れたり、考えてみよう。世界にある金融が見えると、ぐっと金融が楽しくなるかも♪ このページでは、金融に関わるスポットを更新していきます。あなたのオススメの金融・金運スポットがありましたら、ぜひ教えてください♪';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/kinyumap/index.smarty', $this->data);
    }

    public function action_ooedo_ito()
    {
        $this->data['company'] = Companies::get();
        $this->template->title = '大江戸温泉リートの投資先を見てみよう！｜きんゆう女子。';
        $this->template->description = '大江戸温泉リートの投資先を見てみよう！';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu_map/og/map_ooedoito.jpg';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->map_last = View::forge('kinyu/kinyumap/map_last.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/kinyumap/ooedo_ito.smarty', $this->data);
    }

    public function action_map_kabuto()
    {
        $this->template->title = 'かぶと町マップ｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu_map/og/map_kubuto.jpg';
        $this->template->description = 'レトロな町・金ゆうの町、日本橋兜町・茅場町。あまり知られていない、かくれ家的なお店がいっぱい！！ きんゆう女子。おすすめのスポットをご紹介♪';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->map_last = View::forge('kinyu/kinyumap/map_last.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/kinyumap/map_kabuto.smarty', $this->data);
    }

    public function action_sanpo_nihonginko()
    {
        $this->template->title = 'かぶと町マップ｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu_map/og/og-main.jpg';
        $this->template->description = 'レトロな町・金ゆうの町、日本橋兜町・茅場町。あまり知られていない、かくれ家的なお店がいっぱい！！ きんゆう女子。おすすめのスポットをご紹介♪';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->map_last = View::forge('kinyu/kinyumap/map_last.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/kinyumap/sanpo_nihonginko.smarty', $this->data);
    }

    public function action_sanpo_hiroshima()
    {
        $this->template->title = 'きんゆう散歩＠広島｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu_map/og/og-main.jpg';
        $this->template->description = '金運アップを目指して、広島県で私たちが気になるスポットをいくつか巡ってきました♪';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);
        $this->template->map_last = View::forge('kinyu/kinyumap/map_last.smarty', $this->data);

        $this->template->contents = View::forge('kinyu/kinyumap/sanpo_hiroshima.smarty', $this->data);
    }
}
