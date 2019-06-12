<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Businessinquirycategories extends Base
{

    public static function lists()
    {

        $categories = \DB::select("*")
            ->from('business_inquiry_categories')
            ->where('disable', '=', 0)
            ->order_by('sort', 'asc')
            ->execute()
            ->as_array();

        $keys = array();
        foreach ($categories as $key => $category) {
            $keys[$category['code']] = $category;
        }
        return $keys;
    }

}
