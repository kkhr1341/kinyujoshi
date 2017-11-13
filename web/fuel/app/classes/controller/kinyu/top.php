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
//    $this->data['pagination'] = $pagination::instance('mypagination');
	  $this->data['events'] = Events::lists(1, 5, true, 'kinyu');
    $this->template->title = 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ';
    $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['blogs_pick'] = Blogs::lists_picks(1, 5, true);
    $this->template->reload_animation = View::forge('kinyu/template/reload_animation.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/index.smarty', $this->data)
          ->set_safe('pagination', $pagination);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/pc_index.smarty', $this->data)
          ->set_safe('pagination', $pagination);
    }


	}

  public function action_testindex($page=1) {

    switch (true) {
      case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
      case $_SERVER['PHP_AUTH_USER'] !== 'test':
      case $_SERVER['PHP_AUTH_PW']   !== 'test':
      header('WWW-Authenticate: Basic realm="Enter username and password."');
      //header('Content-Type: text/plain; charset=utf-8');
      die('このページを見るにはログインが必要です');
    }

    $this->data['projects'] = Projects::lists(1, 3, true, 'kinyu');
    $this->data['news'] = News::lists(1, 3, true, 'kinyu');
    $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/blog/', $page, 2, 10);
    $pagination = $this->data['blogs']['pagination'];
//    $this->data['pagination'] = $pagination::instance('mypagination');
    $this->data['events'] = Events::lists(1, 5, true, 'kinyu');
    $this->template->title = 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ';
    $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials02'] = Blogs::lists(1, 4, true, 'special');
    $this->data['specials'] = Blogs::lists02(1, 5, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/index.smarty', $this->data);
    $this->template->pc_contents = View::forge('kinyu/index-backup.smarty', $this->data);
  }

  public function action_testspindex($page=1) {

    switch (true) {
      case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
      case $_SERVER['PHP_AUTH_USER'] !== 'test':
      case $_SERVER['PHP_AUTH_PW']   !== 'test':
      header('WWW-Authenticate: Basic realm="Enter username and password."');
      //header('Content-Type: text/plain; charset=utf-8');
      die('このページを見るにはログインが必要です');
    }

    $this->data['projects'] = Projects::lists(1, 3, true, 'kinyu');
    $this->data['news'] = News::lists(1, 3, true, 'kinyu');
    $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/blog/', $page, 2, 10);
    $pagination = $this->data['blogs']['pagination'];
//    $this->data['pagination'] = $pagination::instance('mypagination');
    $this->data['events'] = Events::lists(1, 5, true, 'kinyu');
    $this->template->title = 'きんゆう女子。- 金融ワカラナイ女子のためのコミュニティ';
    $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。なかなか聞けない、お金の話。 先延ばしにしがちな、お金の計画。 私には無関係と思っている、金融の話。みんなのお金に関するあれこれをおしゃべりしましょう！';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-top.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials02'] = Blogs::lists(1, 4, true, 'special');
    $this->data['specials'] = Blogs::lists02(1, 5, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/template/testsp.smarty', $this->data);
    $this->template->pc_contents = View::forge('kinyu/index-backup.smarty', $this->data);
  }

  public function action_detail($code) {
    // 最新を取得
    $this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
    //print_r($this->data['blogs']);
    //print_r($this->data);
    $this->data['blog'] = Blogs::getByCodeWithProfile($code);
    $this->template->title = $this->data['blog']['title'];
    $this->template->description = $this->data['blog']['title'];
    $this->template->ogimg = $this->data['blog']['main_image'];
    $this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
    //カテゴリーの部分
  }

}