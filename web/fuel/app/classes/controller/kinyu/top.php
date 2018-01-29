<?php

use \Model\Blogs;
use \Model\News;
use \Model\Events;
use \Model\Projects;
use \Model\Wp;

class Controller_Kinyu_Top extends Controller_Kinyubase
{
	public function action_index($page=1) {
	$this->data['projects'] = Projects::lists(1, 3, true, 'kinyu');
	$this->data['news'] = News::lists(1, 1, true);
  if(Agent::is_mobiledevice()) {
    $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/report/', $page, 2, 20);
  } else {
    $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/report/', $page, 2, 60);
  }
    $pagination = $this->data['blogs']['pagination'];
    $this->data['pagination'] = $pagination::instance('mypagination');
	  $this->data['events'] = Events::lists(1, 10, true, 'kinyu');
    $this->template->title = 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ';
    $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 9, true);
    $this->data['top_blogs2'] = Blogs::lists02(1, 12, true);
    $this->data['blogs_pick'] = Blogs::lists_picks(1, 5, true);
    $this->template->reload_animation = View::forge('kinyu/template/reload_animation.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
    $this->template->pickup_top = View::forge('kinyu/common/pickup_top.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/index.smarty', $this->data);
    } else {
      $this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data);
    }


	}



}