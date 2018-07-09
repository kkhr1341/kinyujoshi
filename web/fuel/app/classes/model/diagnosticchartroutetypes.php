<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartRouteTypes extends Base
{

    public static function getTypeCode($route_code, $yes_no)
    {
        $result = \DB::select('*')
            ->from('diagnostic_chart_route_types')
            ->where('route_code', '=', $route_code)
            ->where('yes_no', '=', $yes_no)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result['type_code'];
    }
}
