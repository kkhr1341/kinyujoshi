<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Top extends Base
{


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
        $datas = $datas->execute('slave')
            ->as_array();
        return $datas;
    }

    public static function create($params)
    {

        $code = self::getNewCode('blogs');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        $params['main_image'] = self::get_main_image($params);
        \DB::insert('blogs')->set($params)->execute();

        return $params;
    }


    public static function save($params)
    {

        $username = \Auth::get('username');
        $params['main_image'] = self::get_main_image($params);

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

        $total = $total->execute('slave')->current();

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
            ->where('blogs.status', '=', 1)
            ->where('blogs.open_date', '<', \DB::expr('NOW()'));

        if ($section_code !== null) {
            $datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
        }

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->order_by('open_date', 'desc')
            ->execute('slave')
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
            ->execute('slave')->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

}
