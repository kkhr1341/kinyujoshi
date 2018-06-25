<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Blogs extends Base
{
    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code');
//        $val->add('username');
//        $val->add('section_code');
        $val->add('project_code');
        $val->add('status');
        $val->add('open_date');
        $val->add('secret');
        $val->add('title');
        $val->add('content');
        $val->add('main_image');
//        $val->add('disable');
        $val->add('description');
//        $val->add('section_name');
        $val->add('pickup');
        $val->add('kind');
        $val->add('keyword');
        $val->add('where_from');
        $val->add('where_from_other');
        $val->add('authentication_user', '認証ユーザー名')
            ->add_rule('required_with', 'authentication_password');
        $val->add('authentication_password', '認証パスワード')
            ->add_rule('required_with', 'authentication_user');

        return $val;
    }

    /**
     * 指定のプロジェクトの活動報告を取得する
     * public static function reports($project_code) {
     *
     * return \DB::select('*')->from('blogs')->where(
     * array(
     * 'project_code' => $project_code,
     * 'disable' => 0
     * )
     * )
     * ->order_by('open_date', 'DESC')
     * ->execute()->as_array();
     * }
     */

    public static function lists($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null)
    {

        $datas = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.kind', '!=', 'わたしを知る')
            ->where('blogs.disable', '=', 0);

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($project_code === null) {
        } else {
            $datas = $datas->where('project_code', '=', $project_code);
        }

        if ($section_code === null) {
        } else {
            $datas = $datas->where('section_code', '=', $section_code);
        }

        $datas = $datas->order_by(\DB::expr('RAND()'));

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }

    public static function lists02($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null)
    {

        $datas = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.disable', '=', 0);

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($project_code === null) {
        } else {
            $datas = $datas->where('project_code', '=', $project_code);
        }

        if ($section_code === null) {
        } else {
            $datas = $datas->where('section_code', '=', $section_code);
        }

        $datas = $datas->order_by('blogs.open_date', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }

    public static function listspick($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null)
    {

        $datas = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.pickup', '=', 1)
            ->where('blogs.disable', '=', 0);

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($project_code === null) {
        } else {
            $datas = $datas->where('project_code', '=', $project_code);
        }

        if ($section_code === null) {
        } else {
            $datas = $datas->where('section_code', '=', $section_code);
        }

        $datas = $datas->order_by('blogs.id', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }

    public static function lists_picks($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null)
    {

        $datas = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.pickup', '=', 1)
            ->where('blogs.disable', '=', 0);

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($project_code === null) {
        } else {
            $datas = $datas->where('project_code', '=', $project_code);
        }

        if ($section_code === null) {
        } else {
            $datas = $datas->where('section_code', '=', $section_code);
        }

        $datas = $datas->order_by('open_date', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        return $datas;
    }

    public static function create($params)
    {

        $code = self::getNewCode('blogs');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['section_code'] = '';
        $params['section_name'] = '';
        $params['created_at'] = \DB::expr('now()');

        \DB::insert('blogs')->set($params)->execute();

        return $params;
    }


    public static function save($params)
    {

//        $username = \Auth::get('username');

        \DB::update('blogs')->set($params)->where('code', '=', $params['code'])->execute();

        return $params;
    }

    public static function delete($params)
    {

        $username = \Auth::get('username');
        \DB::update('blogs')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();

        return $params;
    }

    private static function get_main_image($params)
    {

        $content = $params['content'];
        preg_match_all("/src=\"(.*?)\"/", $content, $result);
        $url = "";
        if (isset($result[1]) && isset($result[1][0])) {

            $url = $result[1][0];
            if (strpos($url, "youtube.com") !== false) {
                preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $url, $matches);
                if (isset($matches[2]) && $matches[2] != '') {
                    $YoutubeCode = $matches[2];
                }
                $url = "//img.youtube.com/vi/{$YoutubeCode}/0.jpg";
            }
        }

        return $url;
    }


    public static function all($section_code = null, $pagination_url, $page, $uri_segment = 3, $per_page = 5)
    {

        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('blogs')
            ->where('status', '=', 1)
            ->where('open_date', '<', \DB::expr('NOW()'))
            ->where('blogs.disable', '=', 0);

        if ($section_code !== null) {
            $total = $total->where('section_code', '=', $section_code);
        }

        $total = $total->execute()->current();

        $config = array(
            'pagination_url' => $pagination_url,
            'total_items' => $total['cnt'],
            'per_page' => $per_page,
            'uri_segment' => $uri_segment,
            'current_page' => (int)$page,
            'name' => 'bootstrap',
            'wrapper' => '<ul class="pagination">{pagination}</ul>',
        );

        $pagination = \Pagination::forge('mypagination', $config);

        $datas['datas'] = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.kind', '!=', 'わたしを知る')
            ->where('blogs.status', '=', 1)
            ->where('blogs.open_date', '<', \DB::expr('NOW()'))
            ->where('blogs.disable', '=', 0);

        if ($section_code !== null) {
            $datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
        }

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->order_by('open_date', 'desc')
            ->execute()
            ->as_array();

        $datas['pagination'] = $pagination;

        return $datas;
    }

    public static function getByCodeWithProfile($code)
    {
        $result = \DB::select('*')->from('blogs')
            ->where('blogs.code', '=', $code)
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->where('blogs.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getByCodeWithurl($code)
    {
        $result = \DB::select('*')->from('blogs')
            ->where('blogs.code', '=', $code)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    // public static function random($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null) {

    // 	$datas = \DB::select(\DB::expr('*, blogs.code'))->from('blogs')
    //        ->join('profiles', 'left')
    //        ->on('blogs.username', '=', 'profiles.username')
    //        ->where('blogs.disable', '=', 0)

    //    ->limit(4)
    //    ->order_by(\DB::expr('RAND()'))
    //    ->execute();
    // }

}