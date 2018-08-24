<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartRouteTypeActionLists extends Base
{

    public static function getContentByTypeCode($type_code)
    {
        $result = \DB::select('*')
            ->from('diagnostic_chart_type_action_lists')
            ->where('type_code', '=', $type_code)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result['content'];
    }
}
