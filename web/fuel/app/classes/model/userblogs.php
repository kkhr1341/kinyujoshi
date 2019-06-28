<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class UserBlogs extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code');
//        $val->add('username');
        $val->add('status');
        $val->add('title');
        $val->add('content');
        $val->add('main_image');

        return $val;
    }

    public static function user_lists($username)
    {
        $datas = \DB::select(
            \DB::expr('user_blogs.*'),
            \DB::expr('blog_user_blogs.blog_code')
        )
            ->from('user_blogs')
            ->join('blog_user_blogs', 'left')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('user_blogs.username', '=', $username)
            ->where('user_blogs.disable', '=', 0);
        return $datas->execute()
            ->as_array();
    }

    public static function applying_lists()
    {
        $datas = \DB::select(
            \DB::expr('user_blogs.*')
        )
            ->from('user_blogs')
            ->where('user_blogs.status', '=', 2)
            ->where(\DB::expr('not exists(select "x" from blog_user_blogs where blog_user_blogs.user_blog_code = user_blogs.code)'))
            ->where('user_blogs.disable', '=', 0);
        return $datas->execute()
            ->as_array();
    }

    public static function apply_update_lists()
    {
        $datas = \DB::select(
            \DB::expr('user_blogs.*'),
            \DB::expr('blog_user_blogs.blog_code')
        )
            ->from('user_blogs')
            ->join('blog_user_blogs', 'inner')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('user_blogs.status', '=', 3)
            ->where('user_blogs.disable', '=', 0);
        return $datas->execute()
            ->as_array();
    }

    public static function apply_delete_lists()
    {
        $datas = \DB::select(
            \DB::expr('user_blogs.*'),
            \DB::expr('blog_user_blogs.blog_code')
        )
            ->from('user_blogs')
            ->join('blog_user_blogs', 'inner')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('user_blogs.status', '=', 4)
            ->where('user_blogs.disable', '=', 0);
        return $datas->execute()
            ->as_array();
    }

    public static function create($params)
    {
        $code = self::getNewCode('user_blogs');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');

        \DB::insert('user_blogs')->set($params)->execute();
        return $params;
    }

    public static function save($params)
    {
        $params['updated_at'] = \DB::expr('now()');
        \DB::update('user_blogs')
            ->set($params)
            ->where('code', '=', $params['code'])
            ->execute();
        return $params;
    }

    public static function relate_blogs($blog_code, $user_blog_code)
    {
        \DB::delete('blog_user_blogs')
            ->where('blog_code', '=', $blog_code)
            ->execute();
        return \DB::insert('blog_user_blogs')->set(array(
            'blog_code' => $blog_code,
            'user_blog_code' => $user_blog_code,
        ))->execute();
    }

    public static function delete($code)
    {
        \DB::update('user_blogs')->set(array('disable' => 1))->where('code', '=', $code)->execute();

        return true;
    }

    public static function getByCodeAndUserName($code, $username)
    {
        $result = \DB::select(
            \DB::expr('user_blogs.*'),
            \DB::expr('blog_user_blogs.blog_code')
        )
            ->from('user_blogs')
            ->join('blog_user_blogs', 'left')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('user_blogs.code', '=', $code)
            ->where('user_blogs.username', '=', $username)
            ->where('user_blogs.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getCodeByBlogCode($blog_code)
    {
        $result = \DB::select(
            \DB::expr('user_blogs.code')
        )
            ->from('user_blogs')
            ->join('blog_user_blogs', 'left')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('blog_user_blogs.blog_code', '=', $blog_code)
            ->where('user_blogs.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result['code'];
    }

    public static function findByCode($code)
    {
        $result = \DB::select(
            \DB::expr('user_blogs.*'),
            \DB::expr('authors.code as author_code'),
            \DB::expr('blog_user_blogs.blog_code')
        )
            ->from('user_blogs')
            ->join('authors', 'inner')
            ->on('authors.username', '=', 'user_blogs.username')
            ->join('blog_user_blogs', 'left')
            ->on('blog_user_blogs.user_blog_code', '=', 'user_blogs.code')
            ->where('user_blogs.code', '=', $code)
            ->where('user_blogs.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }
}
