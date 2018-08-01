<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartTypeUsers extends Base
{

    public static function save($username, $type_code, $routes=array())
    {
        $result = \DB::insert('diagnostic_chart_type_users')
            ->set(array(
                'username' => $username,
                'type_code' => $type_code,
                'created_at' => \DB::expr('now()'),
            ))
            ->execute();

        $id = $result[1];

        foreach ($routes as $route_code)
        {
            \DB::insert('diagnostic_chart_route_users')
                ->set(array(
                    'diagnostic_chart_type_user_id' => $id,
                    'route_code' => $route_code,
                    'created_at' => \DB::expr('now()'),
                ))
                ->execute();
        }
    }
}
