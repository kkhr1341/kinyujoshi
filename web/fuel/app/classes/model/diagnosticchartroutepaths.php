<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartRoutePaths extends Base
{

    public static function getNextRouteCode($route_code, $yes_no)
    {
        $result = \DB::select('*')
            ->from('diagnostic_chart_route_paths')
            ->where('route_code', '=', $route_code)
            ->where('yes_no', '=', $yes_no)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result['next_route_code'];
    }
}
