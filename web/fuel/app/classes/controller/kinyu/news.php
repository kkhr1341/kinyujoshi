<?php

use \Model\News;
use \Model\Blogs;

class Controller_Kinyu_News extends Controller_Kinyubase
{

	public function action_index($page=1) {
		
		$this->data['news'] = News::all('news', '/news/', $page, 2, 10);
		$pagination = $this->data['news']['pagination'];
		$this->template->title = 'ニュース｜きんゆう女子。';
		$this->data['pagination'] = $pagination::instance('mypagination');
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

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
    }
		$this->template->contents = View::forge('kinyu/news/index.smarty', $this->data);

	}

	public function action_detail($code) {
		
    //$this->data['news'] = News::getByCode('news', $code);
    $this->data['news'] = News::getByCodeWithProfile($code);

    if ($this->data['news'] === false) {
       Response::redirect('error/404');
    }
		$this->template->title = $this->data['news']['title'];
		$this->template->description = $this->data['news']['title'];
		$this->template->ogimg = $this->data['news']['main_image'];
	  $this->data['top_blogs'] = Blogs::lists(1, 3, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
		//$this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
		//$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
    $this->template->detail_content_after = View::forge('kinyu/common/detail_content_after.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/news/sp_detail.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      //$this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/news/detail.smarty', $this->data);
    }


	}
}