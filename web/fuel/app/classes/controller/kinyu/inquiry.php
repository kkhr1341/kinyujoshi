<?php

use \Model\Categories;

class Controller_Kinyu_Inquiry extends Controller_Kinyubase
{

	public function action_index() {

		$this->template->title = 'お問い合わせ｜きんゆう女子。';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
		$this->data['categories'] = Categories::lists();
	
		// 		print_r($this->data['categories']);
		//$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);

    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
		$this->template->contents = View::forge('kinyu/inquiry/index.smarty', $this->data);
	
	}
	public function action_complete() {

		$this->template->title = 'お問い合わせ完了｜きんゆう女子。';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		$this->template->description = "きんゆう女子について。きんゆうについてなど疑問に思ったことを何でもお問い合わせください。";
		//$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->tablet_div = View::forge('kinyu/common/tablet_div.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    
		$this->template->contents = View::forge('kinyu/inquiry/complete.smarty', $this->data);
	}
}


