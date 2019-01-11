<?php
/**
 * Created by IntelliJ IDEA.
 * User: kokishiozawa
 * Date: 2019/01/11
 * Time: 14:01
 */

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class BlogAuthors extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name')
            ->add_rule('required');

        $val->add('profile_image')
            ->add_rule('required');

        $val->add('introduction')
            ->add_rule('required');

        return $val;
    }


    public static function create($params)
    {
        $params['created_at'] = \DB::expr('now()');

        \DB::insert('blog_authors')->set($params)->execute();

        return $params;

    }

    public static function save($params)
    {
        $params['updated_at'] = \DB::expr('now()');
        \DB::update('blog_authors')->set($params)->where('code', '=', $params['code'])->execute();
        return $params;

    }

    public static function delete($params)
    {

        \DB::delete('blog_authors')->where('id', '=', $params['id'])->execute();

        return $params;
    }
}
