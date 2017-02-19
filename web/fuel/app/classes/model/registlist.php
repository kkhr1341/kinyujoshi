<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Registlist extends Base { 

  public static function lists($username) {
    
    return \DB::select("*")->from('member_regist')->execute()->as_array();

  }
}
