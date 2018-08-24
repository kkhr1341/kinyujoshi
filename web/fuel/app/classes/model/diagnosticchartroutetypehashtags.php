<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartRouteTypeHashTags extends Base
{

    public static function getTagsByTypeCode($type_code)
    {
        $result = \DB::select('*')
            ->from('diagnostic_chart_type_hash_tags')
            ->where('type_code', '=', $type_code)
            ->execute();
        if (empty($result)) {
            return false;
        }
        $tags = array();
        foreach($result as $value) {
            $tags[] = $value['hash_tag'];
        }
        return $tags;
    }
}
