<?php

use \Model\Blogs;
use \Model\News;
use \Model\Events;

class Controller_Kinyu_Special extends Controller_Kinyubase
{

    // public function action_map()
    // {

    //     $this->template->title = 'かぶと町マップ｜きんゆう女子。';
    //     $this->template->ogimg = 'https://kinyu-joshi.jp/images/map/map-og.jpg';
    //     $this->template->description = 'レトロな町・金ゆうの町、日本橋兜町・茅場町。あまり知られていない、かくれ家的なお店がいっぱい！！ きんゆう女子。おすすめのスポットをご紹介♪';
    //     $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    //     $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    //     $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    //     $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    //     if (Agent::is_mobiledevice()) {
    //         $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
    //         $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
    //     }

    //     $this->template->contents = View::forge('kinyu/campaign/map.smarty', $this->data);
    // }

    public function action_kinyu_sanpo()
    {

        $this->template->title = 'きんゆう散歩｜きんゆう女子。';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/map/map-og.jpg';
        $this->template->description = 'きんゆう散歩';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        }

        $this->template->contents = View::forge('kinyu/special/kinyu_sanpo.smarty', $this->data);
    }

}