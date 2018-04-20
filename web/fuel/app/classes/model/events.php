<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Events extends Base
{


    public static function validate($status)
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code');

        $val->add('section_code');

        $val->add('status');

        $val->add('event_category', 'カテゴリー');

        $val->add('title', '女子会のタイトル');

        $val->add('main_image', 'サムネイル画像');

        $val->add('content', '女子会の詳細');

        $val->add('secret', 'メンバー限定女子会');

        $val->add('event_date', '日付')
            ->add_rule('required')
            ->add_rule('valid_date');

        $val->add('event_start_datetime', '開催開始時間');

        $val->add('event_end_datetime', '開催終了時間');

        $val->add('place', '場所');

        $val->add('place_url', '場所のURL');

        $val->add('fee', '女子会参加費')
            ->add_rule('valid_string','numeric')
            ->add_rule('numeric_between',50, 9999999);

        $val->add('limit', '定員')
            ->add_rule('valid_string', 'numeric')
            ->add_rule('numeric_between',1, 1000);

        $val->add('creditch', '決済方法');

        $val->add('incur_cancellation_fee_date', 'キャンセル料金発生日');

        $val->add('open_date', '公開設定')
            ->add_rule('valid_date');

        if ($status == 1) {

            $val->field('event_category')
                ->add_rule('required');

            $val->field('title')
                ->add_rule('required');

            $val->field('place')
                ->add_rule('required');

            $val->field('fee')
                ->add_rule('required');

            $val->field('event_start_datetime')
                ->add_rule('required');

            $val->field('event_end_datetime')
                ->add_rule('required');

            $val->field('creditch')
                ->add_rule('required');
        }

        return $val;
    }
   
    public static function getByCode($table, $code)
    {
       $event = parent::getByCode($table, $code);
       $event['applicable'] = self::is_applicable_by_event_date($event['event_date']);
       return $event;
    }

    public static function lists($mode = null, $limit = null, $open = null, $secret = null)
    {

        $datas = \DB::select(\DB::expr('*, events.code, (select count(*) from applications where applications.event_code = events.code and applications.disable = 0 and applications.cancel = 0) as application_num'))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0);

        if ($secret === null) {
        } else {
            $datas = $datas->where('secret', '=', $secret);
        }

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        // if ($section_code === null) {
        // }
        // else {
        // 	$datas = $datas->where('section_code', '=', $section_code);
        // }

        //$datas = $datas->order_by('events.id', 'desc');
        $datas = $datas->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        $datas = $datas->order_by('event_date', 'desc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        
        foreach($datas as $key => $data){
            $datas[$key]['applicable'] = self::is_applicable_by_event_date($data['event_date']);
        }

        return $datas;
    }

    public static function lists02($mode = null, $limit = null, $open = null, $section_code = null, $secret = null)
    {

        $datas = \DB::select(\DB::expr('*, events.code, (select count(*) from applications where applications.event_code = events.code and applications.disable = 0 and applications.cancel = 0) as application_num'))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0);
        
        if ($secret === null) {
        } else {
            $datas = $datas->where('secret', '=', $secret);
        }

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open === null) {
        } else {
            $datas = $datas->where('event_date', '<', \DB::expr('NOW()'));
        }

        $datas = $datas->where('event_date', '<=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        $datas = $datas->order_by('event_date', 'asc');

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute()
            ->as_array();
        
        foreach($datas as $key => $data){
            $datas[$key]['applicable'] = self::is_applicable_by_event_date($data['event_date']);
        }

        return $datas;
    }

    public static function create($params)
    {

        $code = self::getNewCode('events');
        $params['username'] = \Auth::get('username');
        if(!$params['incur_cancellation_fee_date']) $params['incur_cancellation_fee_date'] = '0000-00-00 00:00:00';
        $params['limit'] = (!$params['limit'])? 0: $params['limit'];
        $params['code'] = $code;
        $params['created_at'] = \DB::expr('now()');
//        $params['main_image'] = self::get_main_image($params);
        \DB::insert('events')->set($params)->execute();
        return $params;
    }


    public static function save($params)
    {
//        $username = \Auth::get('username');
//        $params['main_image'] = self::get_main_image($params);
//        if(!$params['incur_cancellation_fee_date']) $params['incur_cancellation_fee_date'] = '0000-00-00 00:00:00';
        if(!$params['incur_cancellation_fee_date']) $params['incur_cancellation_fee_date'] = '0000-00-00 00:00:00';

        \DB::update('events')->set($params)->where('code', '=', $params['code'])->execute();

        return $params;
    }

    public static function delete($params)
    {

//        $username = \Auth::get('username');
        \DB::update('events')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();

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


    public static function all($section_code = null, $pagination_url, $page, $uri_segment = 3, $per_page = 5, $secret = null)
    {

        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->where('status', '=', 1)
            ->where('open_date', '<', \DB::expr('NOW()'))
            ->from('events')
            ->where('disable', '=', 0);

        if ($section_code !== null) {
            $total = $total->where('section_code', '=', $section_code);
        }
        if ($secret !== null) {
            $total = $total->where('secret', '=', $secret);
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

        $datas['datas'] = \DB::select(\DB::expr('*, events.code'))->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('status', '=', 1)
            ->where('secret', '=', 0)
            ->where('events.disable', '=', 0)
            ->where('open_date', '<', \DB::expr('NOW()'));

        if ($section_code !== null) {
            $datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
        }
        if ($secret !== null) {
            $datas['datas'] = $datas['datas']->where('secret', '=', $secret);
        }

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'))
            ->order_by('event_date', 'asc')
            ->execute()
            ->as_array();
        
        foreach($datas['datas'] as $key => $data){
            $datas['datas'][$key]['applicable'] = self::is_applicable_by_event_date($data['event_date']);
        }
        
        $datas['pagination'] = $pagination;

        return $datas;
    }

    public static function getByCodeWithProfile($code)
    {
        $result = \DB::select('*')->from('events')
            ->where('events.code', '=', $code)
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    /**
     * イベント申し込みが可能かを確認するメソッド
     * @param $code イベントコード
     * @return bool true: 申し込み可能, false: 申し込み不可
     */
    public static function applicable($code)
    {
        $event = self::getByCode('events', $code);
        return self::is_applicable_by_event_date($event['event_date']);
    }

    private static function is_applicable_by_event_date($event_date)
    {
        $applicableTime = strtotime(date('Y-m-d 13:00:00', strtotime($event_date)));
        if (time() < $applicableTime) {
            return true;
        } 
        return false;
    } 

    /**
     * イベントキャンセルが可能か確認するメソッド
     * @param $code イベントコード
     * @return bool true: キャンセル可能, false: キャンセル不可
     */
    public static function cancelable($code)
    {
        $defaultCancelableDays = 3;
        $event = self::getByCode('events', $code);
        if ($event['incur_cancellation_fee_date'] != '0000-00-00 00:00:00') {
            $cancelableDate = date('Y-m-d', strtotime($event['incur_cancellation_fee_date']));
        } else {
            // キャンセル料発生日の設定がない場合はイベント開催日の3日前からがキャンセル不可となる
            $cancelableDate = date('Y-m-d', strtotime('-' . $defaultCancelableDays . ' day', strtotime($event['event_date'])));
        }
        if (strtotime($cancelableDate) <= strtotime(date('Y-m-d', time()))) {
            return false;
        }
        return true;
    }
}
