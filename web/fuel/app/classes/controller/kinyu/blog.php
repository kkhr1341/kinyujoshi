<?php

use \Model\Blogs;
// use \Model\News;

class Controller_Kinyu_Blog extends Controller_Kinyubase
{

	public function action_index($page=1) {
		
	  $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/report/', $page, 2, 15);
		$pagination = $this->data['blogs']['pagination'];
		$this->data['pagination'] = $pagination::instance('mypagination');
		$this->template->title = '記事一覧｜きんゆう女子。';
		$this->template->description = 'きんゆう女子。は、なかなか聞けないお金の話。 先延ばしにしがちなお金の計画。 私には無関係と思っている金融の話など、お金に関する様々な情報を配信しています。';
		$this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
		//template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    //$this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_side = View::forge('kinyu/common/pc_side.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
      //$this->template->contents = View::forge('kinyu/blog/sp_detail.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      //$this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/blog/index.smarty', $this->data);
		//$this->template->sidebar01 = View::forge('kinyu/sidebar/sidebar01.smarty', $this->data);
	}




	public function action_detail($code) {
		// 最新を取得
		$this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
		$this->data['blog'] = Blogs::getByCodeWithProfile($code);
    
    if ($this->data['blog'] === false) {
       Response::redirect('error/404');
    }

		$this->template->title = $this->data['blog']['title'];
		$this->template->description = $this->data['blog']['description'];
		$this->template->ogimg = $this->data['blog']['main_image'];
		//template
    $this->data['top_blogs'] = Blogs::lists(1, 3, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    //$this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    //$this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
		//$this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->detail_content_after = View::forge('kinyu/common/detail_content_after.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/blog/sp_detail.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->contents = View::forge('kinyu/blog/detail.smarty', $this->data);
    }

	}

  public function action_welcome($code) {
    // 最新を取得
    $this->data['blogs'] = Blogs::all('kinyu', '/kinyu/blog/', 1, 3, 5);
    //print_r($this->data['blogs']);
    //print_r($this->data);
    $this->data['blog'] = Blogs::getByCodeWithProfile($code);
    // if ($this->data['blog'] === false) {
    //    Response::redirect('error/404');
    // }
    $this->template->title = $this->data['blog']['title'];
    $this->template->description = $this->data['blog']['description'];
    $this->template->ogimg = $this->data['blog']['main_image'];
    $this->template->username = $this->data['blog']['username'];
    $code = "";
    $this->template->code = $this->data['blog']['code'];
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/blog/welcome.smarty', $this->data);
  }


}