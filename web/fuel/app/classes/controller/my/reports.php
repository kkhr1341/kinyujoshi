<?php

use \Model\Blogs;
use \Model\Blogstocks;
use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_My_Reports extends Controller_Mybase
{

    public function action_index()
    {
//        $username = \Auth::get('username');
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
//        $username = \Auth::get('username'); //追加
//        $this->data['blogs'] = Blogstocks::lists($username);
//        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
//        $this->template->description = '女子会リスト';

        Asset::css(array(
            'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css'
        ), array(), 'layout', false);

        Asset::js(array(
            'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js'
        ), array(), 'layout', false);

        $this->template->title = 'お気に入り｜きん女。マイページ';
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->contents = View::forge('my/reports/index.smarty', $this->data);
//        $user_type = DiagnosticChartTypeUsers::getLastUserType($username);
//        $this->template->my_side = View::forge('my/common/my_side.smarty', array(
//            'user_type' => $user_type,
//            'hash_tags' => DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($user_type['type_code']),
//            'action_list' => DiagnosticChartRouteTypeActionLists::getContentByTypeCode($user_type['type_code']),
//        ));
    }
}
