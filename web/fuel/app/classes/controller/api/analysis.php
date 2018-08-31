<?php

use \Model\Registlist;
use \Model\DiagnosticChartTypeUsers;

class Controller_Api_Analysis extends Controller_Base
{

    public function before()
    {
        parent::before();

        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }
    }

    /**
     * メンバー属性取得
     */
    public function action_member()
    {
        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }
        if (!$attr = \Input::get('attr')) {
            return $this->error('invalid argument');
        }
        $attr_name = \Input::get('attr_name', '');
        $this->ok(Registlist::member_attribute($attr, $attr_name));
    }

    /**
     * 診断チャート
     */
    public function action_diagnostic_chart_types()
    {
        $group = Auth::group();
        if (!in_array('admin', $group->get_roles())) {
            return $this->error('no administrator');
        }
        $this->ok(DiagnosticChartTypeUsers::get_aggregate_type());
    }
}