<?php

use \Model\Registlist;
use \Model\Blogstocks;
use \Model\DiagnosticChartTypeUsers;
use \Model\Userwithdrawal;

class Controller_Api_Analysis extends Controller_Base
{

    public function before()
    {
        parent::before();

        if (!Auth::has_access('analysis.read')) {
            return $this->error('permission denied');
        }
    }

    /**
     * メンバー属性取得
     */
    public function action_member_attr_count()
    {
        if (!$attr = \Input::get('attr')) {
            return $this->error('invalid argument');
        }

        $this->ok(Registlist::member_attribute_count($attr, array(
            'start_at' => \Input::get('start_at', ''),
            'end_at' => \Input::get('end_at', ''),
            'event_code' => \Input::get('event_code', ''),
        )));
    }

    /**
     * ブログストック取得
     */
    public function action_blog_stock_count()
    {
//        if (!$attr = \Input::get('attr')) {
//            return $this->error('invalid argument');
//        }

        $this->ok(Blogstocks::count(array(
            'start_at' => \Input::get('start_at', ''),
            'end_at' => \Input::get('end_at', ''),
        )));
    }

    /**
     * 診断チャート
     */
    public function action_diagnostic_chart_types()
    {
        $this->ok(DiagnosticChartTypeUsers::get_aggregate_type(array(
            'start_at' => \Input::get('start_at', ''),
            'end_at' => \Input::get('end_at', ''),
            'event_code' => \Input::get('event_code', ''),
        )));
    }

    /**
     * 退会理由
     */
    public function action_user_withdrawal()
    {
        $this->ok(Userwithdrawal::list01());
    }
}