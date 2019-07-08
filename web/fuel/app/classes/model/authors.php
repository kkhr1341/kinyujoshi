<?php
/**
 * Created by IntelliJ IDEA.
 * User: kokishiozawa
 * Date: 2019/01/11
 * Time: 14:01
 */

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Authors extends Base
{

    protected static $_properties = array(
        'id',
        'code',
        'username' => array(
            'default' => ''
        ),
        'position' => array(
            'default' => ''
        ),
        'name' => array(
            'default' => ''
        ),
        'profile_image' => array(
            'default' => ''
        ),
        'introduction' => array(
            'default' => ''
        ),
        'deleted_at',
        'created_at',
        'updated_at',
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array(
                'before_insert'
            ),
            'mysql_timestamp' => true
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array(
                'before_update'
            ),
            'mysql_timestamp' => true
        )
    );

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code', 'CODE');

        $val->add('position', '役職')
            ->add_rule('required');

        $val->add('name', '名前')
            ->add_rule('required');

        $val->add('profile_image', 'プロフィール画像');

        $val->add('introduction', '自己紹介')
            ->add_rule('required');

        return $val;
    }

    public static function lists()
    {
        return \DB::select(
                \DB::expr('authors.*')
            )->from('authors')
            ->execute()
            ->as_array();
    }

    public static function get_by_username($username)
    {
        return \DB::select(\DB::expr('authors.*'))
            ->from('authors')
            ->where('username', '=', $username)
            ->execute()
            ->current();
    }

    public static function all($pagination_url, $page, $uri_segment = 3, $per_page = 5)
    {
        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('authors');

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
            \DB::expr('authors.*')
        )->from('authors');

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->order_by('created_at', 'desc')
            ->execute()
            ->as_array();

        $datas['pagination'] = $pagination;

        return $datas;
    }

    public static function create($params)
    {
        $code = self::getNewCode('blogs');
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
        \DB::insert('authors')
            ->set($params)
            ->execute();
        return $params;
    }

    public static function save($params)
    {
        $params['updated_at'] = \DB::expr('now()');
        \DB::update('authors')
            ->set($params)
            ->where('code', '=', $params['code'])
            ->execute();
        return $params;

    }

    public static function delete($params)
    {
        \DB::delete('authors')
            ->where('code', '=', $params['code'])
            ->execute();
        return $params;
    }
}
