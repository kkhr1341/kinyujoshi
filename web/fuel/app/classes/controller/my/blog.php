<?php

use \Model\Blogs;
use \Model\Blogstocks;
use \Model\Authors;
use \Model\User;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Blog extends Controller_Mybase
{

    public function action_index()
    {
        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $username = \Auth::get('username'); //追加
        $this->data['blogs'] = Blogstocks::lists($username);
        $this->data['top_blogs2'] = Blogs::lists02(1, 12, true, null, null, null, null);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = '女子会リスト';
        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/blog/index.smarty', $this->data);
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
    }
	
	public function action_member_report()
    {
        $username = \Auth::get('username');
        $this->data['blogs'] = Blogs::lists(1, null, 1, null, null, true);
        $this->data['top_blogs2'] = Blogs::lists02(1, 12, true, null, null, null, null);
        $this->template->contents = View::forge('my/blog/member_report.smarty', $this->data);
        $this->template->description = 'マイページ・ブログ';
        $this->template->title = 'メンバー限定レポート｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
		$this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
            'user_type' => $user_type,
            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
        ));
        $this->template->header = View::forge('kinyu/common/header.smarty', $this->data);
        $this->template->footer = View::forge('kinyu/common/footer.smarty', $this->data);
    }

}
