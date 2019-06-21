<?php

use \Model\Authors;
use \Model\UserBlogs;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Userblogs extends Controller_Mybase
{

//    public function before()
//    {
//        parent::before();
//
//        $username = \Auth::get('username');
//        if (!Authors::get_by_username($username)) {
//            return $this->error("オーサーの登録がされておりません。");
//        }
//    }

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);

        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

        $this->data['blogs'] = UserBlogs::user_lists($username);

        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/userblogs/index.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }

    public function action_create()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

        $this->data['author'] = Authors::get_by_username($username);

        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/userblogs/edit.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }
    public function action_edit($code)
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);

        $this->data['author'] = Authors::get_by_username($username);
        $this->data['blog'] = UserBlogs::getByCodeAndUserName($code, $username);

        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/userblogs/edit.smarty', $this->data);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }
}
