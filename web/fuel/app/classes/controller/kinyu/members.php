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

    // どちらも存在しないのはあり得ないので404
    if(!(isset($user) && isset($profile))) {
      return Response::redirect('error/404');
    }

    // 存在しないか公開設定をしていなければ404
    if((int)$profile['disable'] == 1 || (int)$profile['publish'] == '0') {
      return Response::redirect('error/404');
    }

    $joinable_events = Events::joinedEvents($user["username"], false);
    $joined_events = Events::joinedEvents($user["username"], true);

    $this->data['profiles'] = $profile;
    $this->data['user'] = $user;
    $this->data['joinable_events'] = $joinable_events;
    $this->data['joined_events'] = $joined_events;

    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->my_side = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

    $this->template->contents = View::forge('kinyu/members/detail.smarty', $this->data);
  }
}
