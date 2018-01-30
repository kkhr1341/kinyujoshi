<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Profiles extends Base
{
    public static function create($params)
    {

        $params['created_at'] = \DB::expr('now()');

        \DB::insert('profiles')->set($params)->execute();

        return true;
    }

    public static function get($username)
    {

        return \DB::select('*')->from('profiles')->where('disable', '=', 0)->where('username', '=', $username)->execute()->current();

    }

    public static function save($params)
    {

        $username = \Auth::get('username');

//		// コードが既に使用されていないか確認
//		$proile = \DB::select('*')->from('profiles')
//						->where('disable', '=', '0')
//						->where('code', '=', $params['code'])
//						->where('username', '!=', $username)
//						->execute()
//						->current();
//
//		if (!empty($proile)) {
//			return "このユーザー名は既に使用されています";
//		}

        \DB::update('users')->set(array(
            'email' => $params['email']
        ))->where('username', '=', $username)->execute();

        \DB::update('profiles')->set(array(
            'catchcopy' => $params['catchcopy'],
            'nickname' => $params['nickname'],
            'name' => $params['name'],
            'url' => $params['url'],
            'introduction' => $params['introduction'],
            'profile_image' => $params['profile_image']
        ))->where('username', '=', $username)->execute();

        return true;
    }

    public static function lists($mode = null, $limit = null)
    {

        $datas = \DB::select(\DB::expr('*, profiles.code'))
            ->from('profiles')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('profiles.disable', '=', 0);

        // if ($mode === null) {
        // }
        // else {
        //   $datas = $datas->where('status', '=', $mode);
        // }

        // if ($open === null) {
        // }
        // else {
        //   $datas = $datas->where('created_at', '<', \DB::expr('NOW()'));
        // }

        // if ($section_code === null) {
        // }
        // else {
        //   $datas = $datas->where('section_code', '=', $section_code);
        // }

        $datas = $datas->order_by('profiles.id', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }
}
