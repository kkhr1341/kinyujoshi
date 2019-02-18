<?php

use \Model\Events;
use \Model\Sections;
use \Model\Applications;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Events extends Controller_Mybase
{
    public function action_joshikailist()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::lists(1, 50, true);
        $this->data['sections'] = Sections::lists();
        $this->data['all_events'] = Events::lists02();
        $this->data['closed_events'] = Events::lists(0);
        $this->data['open_events'] = Events::lists(1);
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->data['prev_applications'] = Applications::get_prev_events_applications($username);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->title = '参加予定の女子会｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/events/joshikailist.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }

    public function action_joshikaidetail($application_code)
    {
        $username = \Auth::get('username');
        $application = Applications::getByCode("applications", $application_code);
        $this->data['application_code'] = $application_code;
        $code = $application['event_code']; // event code
        $this->data['event'] = Events::getByCodeWithProfile($code);

        $this->data['event_row'] = Events::getByCode('events', $code);
        $this->data['cancelable'] = Events::cancelable($code);
        $this->template->urlcode = $this->data['event_row']['code'];
        $this->template->title = $this->data['event_row']['title'];
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::getByCode('events', $code);
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/events/joshikaidetail.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }

    public function action_member_joshikai()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->data['events'] = Events::lists(1, 50, true, 1);
        $this->data['sections'] = Sections::lists();
        //$this->data['all_events'] = Events::lists02();
        //$this->data['closed_events'] = Events::lists(0);
        //$this->data['open_events'] = Events::lists(1);
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->title = 'myきん女。｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/events/member_joshikai.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }
}
