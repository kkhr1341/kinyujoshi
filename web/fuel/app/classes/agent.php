<?php
class Agent extends Fuel\Core\Agent
{
    public static function _init()
    {
        parent::_init();
        if (
            isset($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER']) &&
            $_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] == 'true'
        ) {
            static::$properties['x_issmartphone'] = true;
        } else {
            static::$properties['x_issmartphone'] = false;
        }
    }
 
    public static function is_smartphone()
    {
        return static::$properties['x_issmartphone'];
    }
}
