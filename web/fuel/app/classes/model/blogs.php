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
        $val->add('pr', 'PR');
        $val->add('secret', 'メンバー限定レポート');
        $val->add('publish', '一般公開設定');
        $val->add('title');
        $val->add('content');
        $val->add('main_image');
//        $val->add('disable');
        $val->add('description');
//        $val->add('section_name');
        $val->add('pickup', 'ピックアップ')
            ->add_rule('required');
        $val->add('kind', 'レポートの種類')
            ->add_rule('required');
        $val->add('keyword');
        $val->add('where_from');
        $val->add('where_from_other');
        $val->add('author_code', '作成者');
        $val->add('authentication_user', '認証ユーザー名')
            ->add_rule('required_with', 'authentication_password');
        $val->add('authentication_password', '認証パスワード')
            ->add_rule('required_with', 'authentication_user');
//        $val->add('blog_contents');

        return $val;
    }

    public static function fetch($options=array())
    {
        \Config::load('blog', true);

        $datas = \DB::select(
            \DB::expr('profiles.*'),
            \DB::expr('blogs.*'),
            \DB::expr('blogs.code'),
            \DB::expr('views_blog_views.views'),
            \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
        )
            ->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->join('views_blog_views', 'left')
            ->on('blogs.code', '=', 'views_blog_views.blog_code')
            ->where('blogs.disable', '=', 0);

        if (!isset($options['mode']) || is_null($options['mode'])) {
        } else {
            $datas = $datas->where('status', '=', $options['mode']);
        }

        if (!isset($options['kind']) || is_null($options['kind']) || !$options['kind']) {
        } else {
            $datas = $datas->where('kind', '=', $options['kind']);
        }

        if (!isset($options['open']) || is_null($options['open'])) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if (!isset($options['project_code']) || is_null($options['project_code'])) {
        } else {
            $datas = $datas->where('project_code', '=', $options['project_code']);
        }

        if (!isset($options['section_code']) || is_null($options['section_code'])) {
        } else {
            $datas = $datas->where('section_code', '=', $options['section_code']);
        }

        if (!isset($options['is_secret']) || is_null($options['is_secret']) || $options['is_secret'] === false) {
        } else {
            $datas = $datas->where('secret', '=', $options['is_secret'] === true ? 1: 0);
        }

        $datas = $datas->order_by('blogs.open_date', 'desc');

        if (!isset($options['limit']) || is_null($options['limit'])) {
        } else {
            $datas = $datas->limit($options['limit']);
        }
        $datas = $datas->execute('slave')
            ->as_array();
        return $datas;
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
    public static function lists($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null, $is_secret=false)
    {
        \Config::load('blog', true);

        $datas = \DB::select(
                \DB::expr('profiles.*'),
                \DB::expr('blogs.*'),
                \DB::expr('blogs.code'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new"),
                \DB::expr('authors.name AS author_name'),
                \DB::expr('authors.profile_image AS author_profile_image')
            )
            ->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->join('authors', 'left')
            ->on('blogs.author_code', '=', 'authors.code')
//            ->where('blogs.kind', '!=', 'わたしを知る')
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

        if ($is_secret === true) {
            $datas = $datas->where('secret', '=', 1);
        } else {
            $datas = $datas->where('secret', '=', 0);
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

    public static function lists02($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null, $username = null, $is_secret=false)
    {
        \Config::load('blog', true);

        $datas = \DB::select(
                \DB::expr('profiles.*'),
                \DB::expr('blogs.*'),
                \DB::expr('blogs.code'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new"),
                \DB::expr('authors.name AS author_name'),
                \DB::expr('authors.profile_image')
            )
            ->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->join('authors', 'left')
            ->on('blogs.author_code', '=', 'authors.code')
//            ->where('blogs.kind', '!=', 'わたしを知る') ->where('blogs.status', 'in', array(1, 3, 4))
            ->where('blogs.disable', '=', 0);

        if ($username === null) {
        } else {
            $datas = $datas->where('blogs.username', '=', $username);
        }

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

        if ($is_secret === false) {
            $datas = $datas->where('secret', '=', 0);
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

    public static function listspick($mode = null, $limit = null, $open = null, $section_code = null, $project_code = null, $is_secret=false, $username = null)
    {
        \Config::load('blog', true);

        $datas = \DB::select(
                \DB::expr('profiles.*'),
                \DB::expr('blogs.*'),
                \DB::expr('blogs.code'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
            )
            ->from('blogs')
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

        if ($is_secret === false) {
            $datas = $datas->where('secret', '=', 0);
        }

        if ($username === null) {
        } else {
            $datas = $datas->where('blogs.username', '=', $username);
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
        \Config::load('blog', true);

        $datas = \DB::select(
                \DB::expr('profiles.*'),
                \DB::expr('blogs.*'),
                \DB::expr('blogs.code'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
            )
            ->from('blogs')
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

    public static function save($params, $blog_contents=array())
    {
        \DB::update('blogs')
            ->set($params)
            ->where('code', '=', $params['code'])
            ->execute();
        return $params;
    }

    public static function delete($params)
    {
        $result = \DB::select(
                \DB::expr('blog_user_blogs.*')
            )
            ->from('blog_user_blogs')
            ->where('blog_user_blogs.blog_code', '=', $params['code'])
            ->execute()
            ->current();
        if ($result) {
            \DB::update('user_blogs')
                ->set(array('disable' => 1))
                ->where('code', '=', $result['user_blog_code'])
                ->execute();
        }

        \DB::update('blogs')
            ->set(array('disable' => 1))
            ->where('code', '=', $params['code'])
            ->execute();

        return $params;
    }

    public static function all($section_code = null, $pagination_url, $page, $uri_segment = 3, $per_page = 5, $search_text='', $is_secret=false)
    {
        \Config::load('blog', true);

        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('blogs')
            ->where('status', 'in', array(1, 3, 4)) // 公開中, 更新依頼中, 削除依頼中
            ->where('open_date', '<', \DB::expr('NOW()'))
            ->where('blogs.disable', '=', 0);

        if ($section_code !== null) {
            $total = $total->where('section_code', '=', $section_code);
        }

        if ($is_secret === false) {
            $total = $total->where('secret', '=', 0);
        }

        if ($search_text !== null) {
            $total = $total
                ->and_where_open()
                ->or_where('title', 'like', '%' . $search_text . '%')
                ->or_where('content', 'like', '%' . $search_text . '%')
                ->and_where_close();
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

        $datas['datas'] = \DB::select(
                \DB::expr('blogs.*'),
                \DB::expr('profiles.*'),
                \DB::expr('authors.name AS author_name'),
                \DB::expr('authors.profile_image'),
                \DB::expr('blogs.code'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
            )->from('blogs')
            ->join('profiles', 'left')
            ->on('blogs.username', '=', 'profiles.username')
            ->join('authors', 'left')
            ->on('blogs.author_code', '=', 'authors.code')
//            ->where('blogs.kind', '!=', 'わたしを知る')
            ->where('blogs.status', 'in', array(1, 3, 4)) // 公開中, 更新依頼中, 削除依頼中
            ->where('blogs.open_date', '<', \DB::expr('NOW()'))
            ->where('blogs.disable', '=', 0);

        if ($section_code !== null) {
            $datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
        }

        if ($is_secret === false) {
            $datas['datas'] = $datas['datas']->where('secret', '=', 0);
        }

        if ($search_text !== null) {
            $datas['datas'] = $datas['datas']
                ->and_where_open()
                ->or_where('title', 'like', '%' . $search_text . '%')
                ->or_where('content', 'like', '%' . $search_text . '%')
                ->and_where_close();
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
        \Config::load('blog', true);

        $result = \DB::select(
                \DB::expr('profiles.*'),
                \DB::expr('blogs.*'),
                \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
            )
            ->from('blogs')
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
        \Config::load('blog', true);

        $result = \DB::select(
                '*',
            \DB::expr("IF(open_date <= now() and now() <= DATE_ADD(open_date, INTERVAL " . \Config::get('blog.new_expire') . " DAY), True, False) as new")
            )
            ->from('blogs')
            ->where('blogs.code', '=', $code)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getByCodeAndUsername($code, $username)
    {
        $result = \DB::select('*')
            ->from('blogs')
            ->where('blogs.code', '=', $code)
            ->where('blogs.username', '=', $username)
            ->where('blogs.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }
}
