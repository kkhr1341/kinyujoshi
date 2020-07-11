<?php

use \Model\User;
use \Model\Profiles;
use \Model\Applications;
use \Model\Events;

class Controller_Kinyu_Members extends Controller_Kinyubase
{
  public function action_index()
  {
  }

  public function action_detail()
  {
    $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    $this->template->title = 'メンバー詳細 ｜きんゆう女子。';
    $this->template->description = 'メンバー詳細';

    $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if (Agent::is_mobiledevice()) {
      $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
      $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }

    $user_id = $this->param('id');
    $user = User::getByUserId($user_id);
    $profile = Profiles::get($user['username']);

    // どちらも存在しないのはあり得ない
    if( !isset($user) && !isset($profile) ) {
      return Response::redirect('/');
    }

    // 存在しないか公開設定をしていなければ404
    if( (int)$profile['disable'] == 1 || (int)$profile['publish'] == 0 ) {
      // TODO: メンバーが増えてきたらメンバー一覧にリダイレクトする
      return Response::redirect('error/404');
    }

    $joinable_events = Events::joinedEvents($user["username"], false);
    $joined_events = Events::joinedEvents($user["username"], true);

    $this->data['profile'] = $profile;
    $this->data['user'] = $user;
    $this->data['joinable_events'] = $joinable_events;
    $this->data['joined_events'] = $joined_events;

    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->my_side = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

    $this->template->contents = View::forge('kinyu/members/detail.smarty', $this->data);

    Asset::css(array(
      //'kinyu/font.css',
      //'kinyu/animate.css',
      'kinyu/redactor.css',
      'kinyu/font-awesome.min.css',
      //'kinyu/bootstrap-datetimepicker.min.css',
      'kinyu/toastr.css',
      //'kinyu/bootstrap-select.min.css',
      'kinyu/bootstrap01.css',
      "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css",

      // 'kinyu/base.css',
      // 'kinyu/bg.css',
      // 'kinyu/style.css',
      // 'kinyu/layout.css',
      // 'kinyu/responsive.css',
      // 'kinyu/kuchikomi.css',

      'kinyu/swiper.min.css',
      //'kinyu/jumboShare.css',
      //'kinyu/drawer.css',

      'base.css',
      'kinyu/bg.css',
      //'style.css',
      'edit_style.css',
      'responsive.css',
      'slick.css',
      'tablet.css'
    ), array(), 'layout', false);
  }
}