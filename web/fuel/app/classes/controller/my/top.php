<?php

use \Model\Blogs;
use \Model\Blogstocks;
use \Model\Applications;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Top extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->data['applications'] = Applications::get_next_events_applications($username);
        $this->data['blogs'] = Blogs::lists(1, null, 1, null, null, true);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->title = 'マイページ｜きんゆう女子。';
        $this->template->description = 'マイページ・トップ';
        //$this->template->contents = View::forge('my/all.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';

        //お役立ちコンテンツ
        if (Agent::is_mobiledevice()) {
            $this->template->useful_content = View::forge('my/useful/useful_content_sp.smarty', $this->data);
        } else {
            $this->template->useful_content = View::forge('my/useful/useful_content.smarty', $this->data);
        }


        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->kinjo_check = View::forge('my/common/kinjo_check.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
        $this->template->contents = View::forge('my/all.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));

    }
}
