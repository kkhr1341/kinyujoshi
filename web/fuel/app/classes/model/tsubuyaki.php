<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Tsubuyaki extends Base
{

    public static function create($params)
    {

        $code = self::getNewCode('tsubuyaki');
        //$params['created_at'] = \DB::expr('now()');
        //$params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        $params['username'] = \Auth::get('username');
        \DB::insert('tsubuyaki')->set($params)->execute();
        return $params;
    }

    public static function lists($mode = null, $limit = null)
    {
        $data_use = \Auth::get('username');
        //print_r($data_use);
        $datas = \DB::select('*')
            ->from('tsubuyaki')
            ->where('username', '=', $data_use);

        //イベントIDが1のものを除外する処理
        // foreach ($datas as $key => $value) {
        //   if($datas[$key]->username == $data_use) {
        //     unset($datas[$key]);
        //   }
        // }

        $datas = $datas->order_by(\DB::expr('RAND()'));

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }

        $datas = $datas->execute()->as_array();
        return $datas;
    }


}