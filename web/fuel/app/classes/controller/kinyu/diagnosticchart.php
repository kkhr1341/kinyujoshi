<?php

use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartTypes;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_Kinyu_Diagnosticchart extends Controller_Kinyubase
{
    public function action_index()
    {
        $this->template->title = '女子会ページ｜きんゆう女子。';
        $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
        if ($username = \Auth::get('username')) {
            $this->data['is_diagnosed'] = DiagnosticChartTypeUsers::is_diagnosed($username);
            $this->data['reset_time'] = DiagnosticChartTypeUsers::get_reset_time($username);
        } else {
            $this->data['is_diagnosed'] = false;
            $this->data['reset_time'] = 0;
        }

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/diagnosticchart/index.smarty', $this->data);
    }
	
    public function action_kinjo_type()
    {
        $this->template->title = 'きんじょ。タイプ｜きんゆう女子。';
        $this->template->description = "きんゆう女子。では、お金に関する様々な情報を学ぶことができるイベントを開催しています。みなさんでお金に関するあれこれをたくさんおしゃべりしましょう！";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/og-jyoshikai.jpg';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        $types = DiagnosticChartTypes::getList();

        $this->data['chart_types'] = array();
        foreach ($types as $key => $type) {
            $this->data['chart_types'][$key] = $type;
            $this->data['chart_types'][$key]['hash_tags'] = DiagnosticChartRouteTypeHashTags::getTagsByTypeCode($type['code']);
            $this->data['chart_types'][$key]['action_list'] = DiagnosticChartRouteTypeActionLists::getContentByTypeCode($type['code']);
        }

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        } else {
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        }
        $this->template->contents = View::forge('kinyu/diagnosticchart/kinjo_type.smarty', $this->data);
    }
}
