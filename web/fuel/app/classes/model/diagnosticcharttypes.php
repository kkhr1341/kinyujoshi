<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartTypes extends Base
{

    public static function getDataByCode($code)
    {
        return parent::getByCode('diagnostic_chart_types', $code);
    }
}
