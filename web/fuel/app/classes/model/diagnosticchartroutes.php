<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartRoutes extends Base
{

    public static function getDataByCode($code)
    {
        $result = \DB::select('*')
            ->from('diagnostic_chart_routes')
            ->where('code', '=', $code)
            ->execute()
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }
}
