<?php

use \Model\Blogs;
// use \Model\News;
use \Model\Events;
// use \Model\Projects;
// use \Model\Wp;

class Controller_Kinyu_Myway extends Controller_Kinyubase
{

  public function action_index() {

    // switch (true) {
    //    case !isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']):
    //    case $_SERVER['PHP_AUTH_USER'] !== 'kinyu-gakuin':
    //    case $_SERVER['PHP_AUTH_PW']   !== '1234567890':
    //    header('WWW-Authenticate: Basic realm="Enter username and password."');
    //    header('Content-Type: text/plain; charset=utf-8');
    //    die('このページを見るにはログインが必要です');
    //  }
    $this->template->title = '「わたし」を知る。｜きんゆう女子。';
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/myway/og_myway.jpg';
    $this->template->description = 'わたしたち、きんゆう女子。は、金融にむきあっていくうちに気づきました。豊かに生きるための第一歩は「自分を知ること」。このページでは、「わたしを知ること」をテーマに情報を発信していきます。';

    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if(Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
    } else {
    }
    $this->template->contents = View::forge('kinyu/myway/index.smarty', $this->data);
  }
}