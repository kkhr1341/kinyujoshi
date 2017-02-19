<?php

use \Model\Blogs;
// use \Model\News;

class Controller_Kinyu_Business extends Controller_Kinyubase
{

  public function action_index($page=1) {
    
    $this->data['business'] = Blogs::all('business', '/blog/', $page, 2, 20);
    //$this->data['specials'] = Blogs::lists(1, 2, true, 'irodori');
    $pagination = $this->data['business']['pagination'];
    $this->data['pagination'] = $pagination::instance('mypagination');
    $this->template->title = 'しごと・きんゆう女子。';
    $this->template->category = 'しごと';
    $this->template->description = '働く女性のための、「しごと」にコンテンツをこのページでまとめています';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/business/index.smarty', $this->data);
    $this->template->sidebar01 = View::forge('kinyu/sidebar/sidebar01.smarty', $this->data);
  }
}