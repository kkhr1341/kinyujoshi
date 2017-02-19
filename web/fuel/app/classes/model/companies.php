<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Companies extends Base {
	
	public static function get() {
		// 一番大きいIDを取得する
		return \DB::select('*')->from('companies')->where('disable', '=', '0')->order_by('id', 'desc')->limit(1)->execute()->current();
	}
	
}
