<?php

use \Model\Authors;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Authors extends Controller_Mybase
{
    public function action_edit()
    {
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $username = \Auth::get('username');
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

        $this->data['author'] = Authors::get_by_username($username);

        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/authors/edit.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }
}