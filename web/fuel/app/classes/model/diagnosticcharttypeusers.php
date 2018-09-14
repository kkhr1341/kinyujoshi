<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class DiagnosticChartTypeUsers extends Base
{

    const EXPIRE = 30;

    // 最新のユーザー診断タイプ情報取得
    public static function getLastUserType($username)
    {
        $user = \DB::select()
            ->from('diagnostic_chart_type_users')
            ->join('diagnostic_chart_types')
            ->on('diagnostic_chart_types.code', '=', 'diagnostic_chart_type_users.type_code')
            ->where('diagnostic_chart_type_users.username', '=', $username)
            ->order_by('diagnostic_chart_type_users.created_at', 'desc')
            ->limit(1);

        if (!$row = $user->execute()->current()) {
            return false;
        }
        return $row;
    }

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

        $id = $result[0];

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

    // ユーザーのタイプを集計
    public static function get_aggregate_type($start_at="", $end_at="")
    {
        $select = 'diagnostic_chart_types.type as label, ';
        $select .= 'DATE_FORMAT(`diagnostic_chart_type_users`.`created_at`, "%Y-%m-%d") as created_at, ';
        $select .= 'count(diagnostic_chart_types.type) as cnt';

        $user = \DB::select(\DB::expr($select))
            ->from('diagnostic_chart_type_users')
            ->join('users')
            ->on('users.username', '=', 'diagnostic_chart_type_users.username')
            ->join('diagnostic_chart_types')
            ->on('diagnostic_chart_types.code', '=', 'diagnostic_chart_type_users.type_code')
//            ->where('users.group', '=', 1)
            ->group_by('diagnostic_chart_types.type', \DB::expr('DATE_FORMAT(`diagnostic_chart_type_users`.`created_at`, "%Y-%m-%d")'));

        if ($start_at) {
            $user->where('diagnostic_chart_type_users.created_at', '>=', $start_at . ' 00:00:00');
        }

        if ($end_at) {
            $user->where('diagnostic_chart_type_users.created_at', '<=', $end_at . ' 23:59:59');
        }

        if (!$row = $user->execute()->as_array()) {
            return array();
        }
        return $row;
    }

}
