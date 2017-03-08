<?php

use \Model\Blogs;
// use \Model\News;
use \Model\Events;
// use \Model\Projects;
// use \Model\Wp;

class Controller_Kinyu_Gallery extends Controller_Kinyubase
{

  public function action_index() {
    
    // $this->data['news'] = News::lists(1, 5, true, 'irodori');
    // $this->data['top_blogs'] = Blogs::lists(1, 3, true, 'kinyu');
    //$this->data['blogs'] = Blogs::lists(1, 12, true, 'kinyu');
    //$this->data['events'] = Events::lists(1, 100, true, 'kinyu');
    $this->template->title = 'きんゆう女子。とは...？｜きんゆう女子。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->description = 'きんゆう女子。は、金融ワカラナイ女子のためのコミュニティです。Aboutページでは、きんゆう女子。についての説明をしています。';
    
    //$this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    //$this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->navigation = View::forge('kinyu/common/pc_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }
    $this->template->contents = View::forge('kinyu/gallery/index.smarty', $this->data);
  }
}