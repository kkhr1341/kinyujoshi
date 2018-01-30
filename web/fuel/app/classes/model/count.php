<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Count extends Base
{

    public static function pagecount()
    {
        $fp = @fopen("counter1.txt", "r+") or die("Counter Error");
        flock($fp, LOCK_EX);
        $count = fgets($fp);
        $count++;
        rewind($fp);
        fputs($fp, $count);
        fclose($fp);
    }
}