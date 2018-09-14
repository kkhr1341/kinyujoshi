<?php

use \Model\Registlist;
use \Model\DiagnosticChartTypeUsers;

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
        $start_at = \Input::get('start_at', '');
        $end_at = \Input::get('end_at', '');

        $this->ok(Registlist::member_attribute_count($attr, $start_at, $end_at));
    }

    /**
     * 診断チャート
     */
    public function action_diagnostic_chart_types()
    {
        $start_at = $attr = \Input::get('start_at', '');
        $end_at = $attr = \Input::get('end_at', '');
        $this->ok(DiagnosticChartTypeUsers::get_aggregate_type($start_at, $end_at));
    }
}