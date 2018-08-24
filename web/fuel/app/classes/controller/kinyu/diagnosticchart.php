<?php

use \Model\DiagnosticChartTypeUsers;
use \Model\DiagnosticChartTypes;
use \Model\DiagnosticChartRouteTypeHashTags;
use \Model\DiagnosticChartRouteTypeActionLists;

class Controller_Kinyu_Diagnosticchart extends Controller_Kinyubase
{
    public function action_index()
    {
        $this->template->title = 'きん女。診断｜きんゆう女子。';
        $this->template->description = "豊かに生きるための第一歩は「自分を知ること」が大切です。わたしはどんな女性になりたい？これから人生を送っていきたい？そして、わたしは実際にどんな人なのだろう...？そういった、自分自身のことを分かってくると、自分に本当に合ったお金の使い方や増やし方も見えてくるし、自信を持って、選ぶこともできます。自分がどのきん女。タイプなのか、3〜6問の質問に答えて診断してみましょう♪";
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/diagnosticchart/og-main.jpg';
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
