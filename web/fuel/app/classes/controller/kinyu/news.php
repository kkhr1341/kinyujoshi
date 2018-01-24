<?php

use \Model\News;
use \Model\Blogs;
use \Model\Events;

class Controller_Kinyu_News extends Controller_Kinyubase
{

	public function action_index($page=1) {
		
		$this->data['news'] = News::all('news', '/news/', $page, 2, 10);
		$pagination = $this->data['news']['pagination'];
		$this->template->title = 'ニュース｜きんゆう女子。';
//		$this->data['pagination'] = $pagination::instance('mypagination');
		$this->template->description = "きんゆう女子。のニュースでは、きんゆう女子。に関する様々なニュースを配信しています。";
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');

    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);
    $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
    }
		$this->template->contents = View::forge('kinyu/news/index.smarty', $this->data)
            ->set_safe('pagination', $pagination);

	}

	public function action_detail($code) {
		
    //$this->data['news'] = News::getByCode('news', $code);
    $this->data['news'] = News::getByCodeWithProfile($code);
    $this->data['top_events'] = Events::lists(1, 7, true);

    if ($this->data['news'] === false) {
       Response::redirect('error/404');
    }

    if ($this->data['news']['status'] == 0) {
      $iddate = $this->data['blog']['code'];
      switch (true) {
        case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
        case $_SERVER['PHP_AUTH_USER'] !==  'kinyu-news':
        case $_SERVER['PHP_AUTH_PW']   !== 'iYszQGhE':
        header('WWW-Authenticate: Basic realm="Enter username and password."');
        header('Content-Type: text/plain; charset=utf-8');
        die('このページを見るにはログインが必要です');
      }
    }
    
	$this->template->title = $this->data['news']['title'];
	$this->template->description = $this->data['news']['title'];
	$this->template->ogimg = $this->data['news']['main_image'];
    $this->data['top_news'] = News::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->detail_news_after = View::forge('kinyu/news/detail_news_after.smarty', $this->data);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/news/detail.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->detail_news_after = View::forge('kinyu/news/detail_news_spafter.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->detail_news_after = View::forge('kinyu/news/detail_news_after.smarty', $this->data);
    }


	}
}