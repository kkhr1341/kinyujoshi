<?php

use \Model\Blogs;
use \Model\Events;
use \Model\Authors;
use \Model\User;
use \Model\Applications;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Top extends Controller_Mybase
{

    const EVENT_DISPLAY_LIMIT = 6;

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->data['blogs'] = Blogs::lists(1, null, 1, null, null, true);
        $this->data['top_blogs2'] = Blogs::lists02(1, 12, true, null, null, null, null);
        $this->data['event_display_limit'] = self::EVENT_DISPLAY_LIMIT;
        $this->data['secret_events'] = Events::lists(1, 4, 'enable_only', 1, "desc", 1, null, null);

        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        //$this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);

        //お役立ちコンテンツ
        if (Agent::is_mobiledevice()) {
            $this->template->useful_content = View::forge('my/useful/useful_content_sp.smarty', $this->data);
        } else {
            $this->template->useful_content = View::forge('my/useful/useful_content.smarty', $this->data);
        }

        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

        $hash_tags = DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']);
        $action_list = DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']);

        $this->template->kinjo_check = View::forge('my/common/kinjo_check.smarty', array(
            'user_type'   => $user_type,
            'hash_tags'   => $hash_tags,
            'action_list' => $action_list,
        ));
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type'   => $user_type,
            'hash_tags'   => $hash_tags,
            'action_list' => $action_list,
        ));
        $this->template->contents = View::forge('my/all.smarty', array(
            'user_type'   => $user_type,
            'hash_tags'   => $hash_tags,
            'action_list' => $action_list,
        ));

    }
}
