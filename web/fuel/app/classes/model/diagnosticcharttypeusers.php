<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartTypeUsers extends Base
{

    const EXPIRE = 30;

    // 最終診断日から30日以上経過している診断データがある場合にtrueを
    // それ以外の場合にfalseを返すメソッド
    public static function is_diagnosed($username)
    {
        $total = \DB::select()
            ->from('diagnostic_chart_type_users')
            ->where('username', '=', $username);

        if (!$total->execute()->current()) {
            return false;
        }

        $total = \DB::select()
            ->from('diagnostic_chart_type_users')
            ->where('username', '=', $username)
            ->where(\DB::expr('DATE_ADD(created_at, INTERVAL ' . self::EXPIRE . ' DAY) >= now()'));

        return $total->execute()->current() ? true : false;
    }

    public static function get_reset_time($username)
    {
        $total = \DB::select(\DB::expr('DATE_ADD(created_at, INTERVAL ' . self::EXPIRE . ' DAY) as created_at'))
            ->from('diagnostic_chart_type_users')
            ->where('username', '=', $username)
            ->where(\DB::expr('DATE_ADD(created_at, INTERVAL ' . self::EXPIRE . ' DAY) >= now()'));

        $row = $total->execute()->current();
        if (!$row) {
            return false;
        }
        return $row['created_at'];
    }

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
