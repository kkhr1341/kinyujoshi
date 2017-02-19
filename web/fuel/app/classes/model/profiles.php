<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Profiles extends Base {
	
	
	public static function create($params) {
		
		$params['created_at'] = \DB::expr('now()');
		
		\DB::insert('profiles')->set($params)->execute();
		
		return true;
	}
	
	public static function get($username) {
		
		return \DB::select('*')->from('profiles')->where('disable', '=', 0)->where('username', '=', $username)->execute()->current();
		
	}
	
	public static function save($params) {

		$username = \Auth::get('username');
		
		// コードが既に使用されていないか確認
		$proile = \DB::select('*')->from('profiles')
						->where('disable', '=', '0')
						->where('code', '=', $params['code'])
						->where('username', '!=', $username)
						->execute()
						->current();
		
		if (!empty($proile)) {
			return "このユーザー名は既に使用されています";
		}
		
		\DB::update('profiles')->set($params)->where('username', '=', $username)->execute();
		
		return true;
	}

	public static function lists($mode = null, $limit = null) {
    
    $datas = \DB::select(\DB::expr('*, profiles.code'))
    ->from('profiles')
    //->join('profiles', 'left')
    //->on('events.username', '=', 'profiles.username')
    ->where('profiles.release_profile', '=', 1);

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
    }
    else {
      $datas = $datas->limit($limit);
    }
    $datas = $datas->execute()
        ->as_array();
    return $datas;
  }
	
}
