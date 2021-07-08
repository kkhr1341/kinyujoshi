<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Blogstocks extends Base
{

    public static function create($blog_code, $username)
    {
        $params['username'] = $username;
        $params['blog_code'] = $blog_code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('blog_stocks')->set($params)->execute();

        return $params;
    }

    public static function delete($blog_code, $username)
    {
//        $username = \Auth::get('username');
        \DB::delete('blog_stocks')
            ->where('blog_code', '=', $blog_code)
            ->where('username', '=', $username)
            ->execute();
    }

    public static function stocked($blog_code, $username)
    {
        $result = \DB::select('*')
            ->from('blog_stocks')
            ->where('blog_code', '=', $blog_code)
            ->where('username', '=', $username)
            ->execute('slave')
            ->current();
        if (empty($result)) {
            return false;
        }
        return true;
    }

    public static function lists($username)
    {
        return \DB::select(\DB::expr('blogs.*'))
            ->from('blogs')
            ->join('blog_stocks')
            ->on('blogs.code', '=', 'blog_stocks.blog_code')
            ->where('blog_stocks.username', '=', $username) //追加
            ->where('blogs.status', '=', 1)
            ->where('blogs.disable', '=', 0)
            ->execute('slave')
            ->as_array();
    }

    public static function count($options)
    {
        $select =  \DB::select('blogs.title', 'blog_stocks.created_at')
            ->from('blogs')
            ->join('blog_stocks')
            ->on('blogs.code', '=', 'blog_stocks.blog_code')
            ->where('blogs.status', '=', 1)
            ->where('blogs.disable', '=', 0);

        if (isset($options['start_at']) && $options['start_at']) {
            $select->where('blog_stocks.created_at', '>=', $options['start_at'] . ' 00:00:00');
        }

        if (isset($options['end_at']) && $options['end_at']) {
            $select->where('blog_stocks.created_at', '<=', $options['end_at'] . ' 23:59:59');
        }

        if (!$row = $select->execute('slave')->as_array()) {
            return array();
        }
        return $row;
    }

}
