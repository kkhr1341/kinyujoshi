<?php

class Controller_My_Profile extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->template->email = Auth::get('email');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->contents = View::forge('my/profile/index.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'プロフィール｜きん女。マイページ';
        $this->template->title = 'プロフィール｜きん女。マイページ';
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }

    public function action_edit()
    {
        $username = \Auth::get('username');
        $this->template->email = Auth::get('email');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->contents = View::forge('my/profile/edit.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'プロフィール編集｜きん女。マイページ';
        $this->template->title = 'プロフィール編集｜きん女。マイページ';
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
    }
}
