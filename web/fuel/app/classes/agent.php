<?php
class Agent extends Fuel\Core\Agent
{
      public static function _init()
    {
        parent::_init();
        // CloudFront経由の場合
        if (isset($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'])) {
            if ($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] == 'true') {
                static::$properties['x_issmartphone'] = true;
            } else {
                static::$properties['x_issmartphone'] = false;
            }
        } else {
            $sp_list = array(
                'iPhone',
                'iPod',
                'ipad',
                'Android',
                'IEMobile',
                'dream',
                'CUPCAKE',
                'blackberry9500',
                'blackberry9530',
                'blackberry9520',
                'blackberry9550',
                'blackberry9800',
                'webOS',
                'incognito',
                'webmate'
            );

            $pattern = '/'.implode('|', $sp_list).'/i';
            static::$properties['x_issmartphone'] = preg_match($pattern, static::$user_agent) ? true : false;
        }
    }

    public static function is_smartphone()
    {
        return static::$properties['x_issmartphone'];
    }
}
