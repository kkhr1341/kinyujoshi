<?php

use \Model\Blogs;

class Controller_Kinyu_Rss extends Controller_Rssbase
{

  public function action_index() {
    // 最新を取得
    $this->data['rss'] = Blogs::lists02(1, 20, true, 'kinyu'+'investment');
    $this->data['blog'] = Blogs::getByCodeWithurl($code);
    $this->template->title = $this->data['blog']['title'];
    $this->template->description = $this->data['blog']['description'];
    $this->template->ogimg = $this->data['blog']['main_image'];
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    //$this->template->contents = View::forge('kinyu/rss/rss2.php', $this->data);
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/rss/index.smarty', $this->data);
  }

  public function action_detail($code) {
    // 最新を取得
    //$this->data['rss'] = Blogs::all('kinyu'+'investment', '/blog/', $page, 2, 50);
    $this->data['rss'] = Blogs::lists02(1, 20, true, 'kinyu'+'investment');
    $this->data['blog'] = Blogs::getByCodeWithurl($code);
    $this->template->title = $this->data['blog']['title'];
    $this->template->description = $this->data['blog']['description'];
    $this->template->ogimg = $this->data['blog']['main_image'];
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    //$this->template->contents = View::forge('kinyu/rss/rss2.php', $this->data);
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/rss/rss.smarty', $this->data);

  }
}