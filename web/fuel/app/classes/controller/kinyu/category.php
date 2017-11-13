<?php

use \Model\Blogs;
// use \Model\News;

class Controller_Kinyu_Category extends Controller_Kinyubase
{

  public function action_index($page=1) {
    
    $this->data['blogs'] = Blogs::all('kinyu'+'investment', '/blog/', $page, 2, 10);
    $pagination = $this->data['blogs']['pagination'];
//    $this->data['pagination'] = $pagination::instance('mypagination');
    $this->template->title = '記事一覧｜きんゆう女子。';
    $this->template->description = 'きんゆう女子。は、なかなか聞けないお金の話。 先延ばしにしがちなお金の計画。 私には無関係と思っている金融の話など、お金に関する様々な情報を配信しています。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    //template
    $this->data['top_blogs'] = Blogs::lists(1, 5, true);
    $this->data['specials'] = Blogs::lists(1, 5, true, 'special');
    $this->data['specials02'] = Blogs::lists02(1, 4, true, 'special');
    $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
    $this->template->navi_contents = View::forge('kinyu/template/navi_contents.smarty', $this->data);
    $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
    $this->template->contents_after_area = View::forge('kinyu/template/contents-after.smarty', $this->data);
    $this->template->contents = View::forge('kinyu/blog/index.smarty', $this->data)
        ->set_safe('pagination', $pagination);
    $this->template->sidebar01 = View::forge('kinyu/sidebar/sidebar01.smarty', $this->data);
  }


}