<?php

use \Model\Events;
use \Model\Blogs;
use \Model\Profiles;
use \Model\Eventkuchikomi;
use \Model\Applications;

class Controller_Kinyu_Event extends Controller_Kinyubase
{


	public function action_index($page=1) {
		// $this->data['events'] = Events::all('event', '/event/', $page, 2, 20);
		// $pagination = $this->data['events']['pagination'];
		// $this->data['pagination'] = $pagination::instance('mypagination');
    $this->data['eventall'] = Events::lists03(1, 50, true);
    //$this->data['events'] = Events::lists(1, 5, true);
		$this->template->title = 'いつもの女子会。｜きんゆう女子。';
		$this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
		$this->template->today = date("Y年n月");
  	$this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);

  	if(Agent::is_mobiledevice()) {
    	$this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
    	$this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
  	} else {
    	$this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
    	$this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
  	}
		$this->template->contents = View::forge('kinyu/event/index.smarty', $this->data);
	}

  public function action_choice($page=1) {
    $this->data['events'] = Events::all('event', '/event/', $page, 2, 20);
    $pagination = $this->data['events']['pagination'];
    $this->data['pagination'] = $pagination::instance('mypagination');
    //$this->data['events'] = Events::lists(1, 5, true);
    $this->template->title = '女子会の選択｜きんゆう女子。';
    $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
    $this->template->today = date("Y年n月");
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/event/choice.smarty', $this->data);
  }

  public function action_special($page=1) {
    // $this->data['events'] = Events::all('event', '/event/', $page, 2, 20);
    // $pagination = $this->data['events']['pagination'];
    // $this->data['pagination'] = $pagination::instance('mypagination');
    //$this->data['events'] = Events::lists(1, 5, true);
    $this->data['eventall'] = Events::lists04(1, 50, true);
    $this->template->title = '特別女子会。｜きんゆう女子。';
    $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
    $this->template->today = date("Y年n月");
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/event/special.smarty', $this->data);
  }

	public function action_welcome($page=1) {
	
		// if (!Auth::check()) {
		// 	Response::redirect('/login');
		// }
		// else {
			$this->data['events'] = Events::all('kinyu', '/event/', $page, 2, 8);
			$pagination = $this->data['events']['pagination'];
			$this->data['pagination'] = $pagination::instance('mypagination');
			$this->template->title = '女子会について｜きんゆう女子。';
			$this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
			$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
			$this->template->today = date("Y年n月"); 
			$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    	$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
			$this->template->contents = View::forge('kinyu/event/welcome.smarty', $this->data);
			$this->template->sidebar01 = View::forge('kinyu/sidebar/sidebar01.smarty', $this->data);
		//}
	}
	
	public function action_detail($code) {

		// 最新を取得
		$this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5);
		$this->data['event'] = Events::getByCodeWithProfile($code);
		$this->data['eventkuchikomi'] = Eventkuchikomi::lists(1,100);
		$this->template->title = 'イベント詳細｜きんゆう女子。';
		$this->data['join_status'] = Applications::join_status($code);
		//$this->data['event'] = Events::getByCode('events', $code);
		$this->template->ogimg = $this->data['event']['main_image'];
		$this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
		$this->template->description = $this->data['event']['title'];
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/event/detail.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
	}
	public function action_schedule() {
		//$this->data['events'] = Events::all('kinyu', '/kinyu/event/', 1, 3, 5);
		$this->template->title = 'イベント詳細｜きんゆう女子。';
		//$this->data['join_status'] = Applications::join_status($code);
		//$this->data['event'] = Events::getByCode('events', $code);
		$this->template->ogimg = $this->data['event']['main_image'];
		 //$this->template->description = $this->data['event']['title'];
		$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
		$this->template->contents = View::forge('kinyu/event/detail.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
	}
}
