<?php

use \Model\Blogs;
use \Model\News;
use \Model\Events;
use \Model\EventDisplayTopPages;
use \Model\Projects;

class Controller_Kinyu_Top extends Controller_Kinyubase
{
    const EVENT_DISPLAY_LIMIT = 6;

    public function action_index($page = 1)
    {
        $this->data['news'] = News::lists(1, 1, true);

        $this->data['event_display_limit'] = self::EVENT_DISPLAY_LIMIT;
        $this->data['events'] = Events::lists(1, null, true, null, 'asc');

        $this->template->title = 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ';
        $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
        //template
        $this->data['top_blogs2'] = Blogs::lists02(1, 12, true, null, null, null, null);
        $this->data['blogs_pick'] = Blogs::lists_picks(1, 5, true);
        $this->data['display_top_event'] = EventDisplayTopPages::get();
        $this->template->reload_animation = View::forge('kinyu/template/reload_animation.smarty', $this->data);
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->side = View::forge('kinyu/common/side.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $this->template->contents = View::forge('kinyu/index.smarty', $this->data);
        $this->template->pickup_top = View::forge('kinyu/common/pickup_top.smarty', $this->data);
        $this->template->contents_after = View::forge('kinyu/common/contents_after.smarty', $this->data);

        // if (Agent::is_smartphone()) {
        //     $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        //     $this->template->contents = View::forge('kinyu/index.smarty', $this->data);
        //     $this->template->pickup_top = View::forge('kinyu/common/sp_pickup_top.smarty', $this->data);
        // } else {
        //     $this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
        //     $this->template->pickup_top = View::forge('kinyu/common/pc_pickup_top.smarty', $this->data);
        // }
    }
}
