<?php

namespace Fuel\Tasks;
use \Model\Apps;

class Lang {
	
	public static function run() {
		
		Apps::site_lang();
		
		echo "fin";
	}

}

/* End of file tasks/robots.php */
