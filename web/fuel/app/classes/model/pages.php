<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Pages extends Base
{

    public static function lists($mode = null, $limit = null, $open = null, $section_code = null)
    {

        $datas = \DB::select("*")->from('pages')->where('disable', '=', 0);

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

    public static function create($params)
    {

        $code = self::getNewCode('pages');
        $params['username'] = \Auth::get('username');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        $params['main_image'] = self::get_main_image($params);
        \DB::insert('pages')->set($params)->execute();

        return $params;
    }


    public static function save($params)
    {

        $username = \Auth::get('username');
        $params['main_image'] = self::get_main_image($params);

        \DB::update('pages')->set($params)->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

        return $params;
    }

    public static function delete($params)
    {

        $username = \Auth::get('username');
        \DB::update('pages')->set(array('disable' => 1))->where('code', '=', $params['code'])->where('username', '=', $username)->execute();

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
            ->from('pages')
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
            'wrapper' => '<ul class="page pagination">{pagination}</ul>',
        );

        $pagination = \Pagination::forge('mypagination', $config);

        $datas['datas'] = \DB::select('*')->from('pages')
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
