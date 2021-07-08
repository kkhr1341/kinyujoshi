<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Courses extends Base
{

    public static function lists($mode = null, $limit = null, $open = null, $section_code = null)
    {

        $datas = \DB::select("*")->from('courses')->where('disable', '=', 0);

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($section_code === null) {
        } else {
            $datas = $datas->where('section_code', '=', $section_code);
        }

        $datas = $datas->order_by('id', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute('slave')
            ->as_array();
        return $datas;
    }

    public static function get_courses($project_code)
    {

        return \DB::select('*')->from('courses')
            ->where('disable', '=', 0)
            ->where('status', '=', 1)
            ->where('project_code', '=', $project_code)
            ->order_by('price', 'ASC')
            ->execute('slave')
            ->as_array();

    }

    public static function create($params)
    {

        $code = self::getNewCode('courses');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        $params['main_image'] = self::get_main_image($params);
        \DB::insert('courses')->set($params)->execute();

        // 公開中のコース
        $open_courses = \DB::select('*')->from('courses')->where('status', '=', 1)->where('project_code', '=', $params['project_code'])->execute()->as_array();

        // 数を増やす
        \DB::update('projects')
            ->set([
                'num_of_courses' => \DB::expr('num_of_courses+1'),
                'num_of_open_courses' => sizeof($open_courses),
            ])
            ->where('code', '=', $params['project_code'])
            ->execute();


        return $params;
    }


    public static function save($params)
    {

        $username = \Auth::get('username');
        $params['main_image'] = self::get_main_image($params);

        \DB::update('courses')->set($params)->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

        // 公開中のコース
        $open_courses = \DB::select('*')->from('courses')->where('status', '=', 1)->where('project_code', '=', $params['project_code'])->execute()->as_array();

        // 数を調整
        \DB::update('projects')
            ->set([
                'num_of_open_courses' => sizeof($open_courses)
            ])
            ->where('code', '=', $params['project_code'])
            ->execute();

        return $params;
    }

    public static function delete($params)
    {

        $username = \Auth::get('username');
        $course = self::getByCode('courses', $params['code']);
        \DB::update('courses')->set(array('disable' => 1))->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

        // 公開中のコース
        $open_courses = \DB::select('*')->from('courses')->where('status', '=', 1)->where('project_code', '=', $params['project_code'])->execute()->as_array();


        // 数を減らす
        \DB::update('projects')
            ->set([
                'num_of_courses' => \DB::expr('num_of_courses-1'),
                'num_of_open_courses' => sizeof($open_courses)
            ])
            ->where('code', '=', $course['project_code'])
            ->execute();

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
            ->from('courses')
            ->where('status', '=', 1)
            ->where('open_date', '<', \DB::expr('NOW()'))
            ->where('disable', '=', 0);

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

        $datas['datas'] = \DB::select('*')->from('courses')
            ->where('status', '=', 1)
            ->where('open_date', '<', \DB::expr('NOW()'));

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
}
