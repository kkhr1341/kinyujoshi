<?php

use \Model\Profiles;
use \Model\Blogs;
use \Model\News;
use \Model\Events;
use \Model\Projects;
use \Model\Wp;

class Controller_My_Top extends Controller_Mybase
{

	public function action_index() {
		
    //phpinfo();
  	if (Auth::has_access('news.admin')) {
      //$id = Auth::get('id');
      $this->template->header = View::forge('kinyu/template/header-area.smarty', $this->data);
      $this->template->footer = View::forge('kinyu/template/footer-area.smarty', $this->data);
      $this->template->contents = View::forge('my/index.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
      $this->template->title = 'マイページ｜きんゆう女子。';
      $this->template->description = 'マイページ・トップ';
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);

  	} else {

      $this->data['events'] = Events::lists(1, 50, true, 'kinyu');
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
      $this->template->title = 'マイページ｜きんゆう女子。';
      $this->template->description = 'マイページ・トップ';
      $this->template->contents = View::forge('my/all.smarty', $this->data);
      $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
  	}

	}
}
