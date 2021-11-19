<?php

use \Model\Events;
use \Model\Sections;
use \Model\Applications;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Mykinjo extends Controller_Mybase
{

		public function action_index()
    {
        $username = \Auth::get('username');
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
        $this->template->contents = View::forge('my/mykinjo/index.smarty', $this->data);
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }


}