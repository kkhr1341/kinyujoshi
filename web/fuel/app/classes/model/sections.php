<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Sections extends Base {
	
	public static function lists($mode = null, $limit = null) {
		
		$sections = \DB::select("*")->from('sections')
				->where('disable', '=', 0)
				->order_by('sort', 'asc')
				->execute()
				->as_array();
		
		$section_keys = [];
		foreach($sections as $key => $section) {
			$section_keys[$section['code']] = $section;
		}
		return $section_keys;
	}
	
}
