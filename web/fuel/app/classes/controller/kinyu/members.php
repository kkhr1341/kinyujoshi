<?php

use \Model\Users;
use \Model\Blogs;
use \Model\Events;
use \Model\Applications;

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
    $this->template->kinyu_event_notes = View::forge('kinyu/event/notes.smarty', $this->data);
    $this->template->social_share = View::forge('kinyu/template/social_share.php', $this->data);
    $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

    if (Agent::is_mobiledevice()) {
        $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    } else {
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
    }


    $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
    $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
    $this->template->my_side = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

    // $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

    // $hash_tags = DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']);
    // $action_list = DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']);

    $this->template->contents = View::forge('kinyu/members/detail.smarty', $this->data);
  }
}
