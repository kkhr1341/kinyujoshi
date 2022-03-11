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

        $val->add('event_category', 'カテゴリー')
            ->add_rule('required');

        $val->add('title', '女子会のタイトル');

        $val->add('main_image', 'サムネイル画像');

        $val->add('content', '女子会の詳細');

        $val->add('secret', 'メンバー限定女子会');

        $val->add('pr', 'PR');

        $val->add('display', '表示/非表示');

        $val->add('display_past', '過去の女子会への表示/非表示');

        $val->add('specific_link', '特定のリンク');
        $val->add('specific_application_link', '特定の申し込みリンク');

        $val->add('event_date', '日付')
            ->add_rule('required')
            ->add_rule('valid_date');

        $val->add('display_event_date', '表示用日付');

        $val->add('event_start_datetime', '開催開始時間')
            ->add_rule('valid_time');

        $val->add('event_end_datetime', '開催終了時間')
            ->add_rule('valid_time');

        $val->add('place', '場所');

        $val->add('place_url', '場所のURL');

        $val->add('fee', '女子会参加費')
            ->add_rule('valid_string','numeric')
            ->add_rule('numeric_between', 0, 9999999);

//        $val->add('coupons', 'クーポンコード');

        for ($i = 0; $i < 5; $i++) {
//            $val->add("coupons.$i.event_coupon_code");

            $val->add("coupons.$i.coupon_code", "クーポンコード$i")
                ->add_rule('match_pattern', '/^[0-9A-Za-z\-]+$/')
                ->add_rule('required_with', 'discount');

            $val->add("coupons.$i.discount", "割引金額$i")
                ->add_rule('required_with', 'coupon_code')
                ->add_rule('valid_string','numeric');
        }

        $val->add('limit', '定員')
            ->add_rule('valid_string', 'numeric')
            ->add_rule('numeric_between', 0, 1000);

        $val->add('creditch', '決済方法');

        $val->add('incur_cancellation_fee_date', 'キャンセル料金発生日');

        $val->add('open_date', '公開設定')
            ->add_rule('required')
            ->add_rule('valid_date');

        $val->add('authentication_user', '認証ユーザー名')
            ->add_rule('required_with', 'authentication_password');

        $val->add('authentication_password', '認証パスワード')
            ->add_rule('required_with', 'authentication_user');

        $val->add('remind_mail.status', '女子会リマインドメール: 有効/無効');
        $val->add('remind_mail.subject', '女子会リマインドメール: 件名');
        $val->add('remind_mail.body', '女子会リマインドメール: 本文')
            ->add_rule('required_with', 'remind_mail.subject');

        $val->add('thanks_mail.status', '女子会サンクスメール: 有効/無効');
        $val->add('thanks_mail.subject', '女子会サンクスメール: 件名');
        $val->add('thanks_mail.body', '女子会サンクスメール: 本文')
            ->add_rule('required_with', 'thanks_mail.subject');

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

    public static function getByCode($table, $code, $coupon_code='')
    {
        $event = parent::getByCode($table, $code);
        $event['applicable'] = self::is_applicable_by_event_date($event['event_date'], $event['event_start_datetime']);
        $application_num = self::get_application_num($code);

        $event['full'] = $application_num >= $event['limit'] ? true: false;

        $event['discount'] = 0;

        if ($coupon_code) {
            $coupon = \DB::select('*')
                ->from('event_coupons')
                ->where('disable', '=', 0)
                ->where('coupon_code', '=', $coupon_code)
                ->where('event_code', '=', $code)
                ->execute('slave')
                ->current();
            if ($coupon) {
                $event['fee'] = (int)$event['fee'] - (int)$coupon['discount'];
                $event['discount'] = (int)$coupon['discount'];
            }
        }
        if ($event['fee'] < 0){
            $event['fee'] = 0;
        }

        return $event;
    }

    // args:
    //   $username  User.username
    //   $past_date True: 過去の女子会を対象にする, False: 開催中の女子会を対象にする
    //   $limit     limit
    public static function joinedEvents($username, $past_date = true, $limit = 5)
    {
      $events = \DB::select('*')
        ->from('events')
        ->where('disable', '=', 0)
        ->where('username', '=', $username);

      if($past_date) {
        $events = $events->where('event_date', '<', time());
      } else {
        $events = $events->where('event_date', '>=', time());
      }

      $events = $events->order_by('event_date', 'asc')
        ->limit($limit)
        ->execute('slave')
        ->as_array();

      return $events;
    }

    private static function get_application_num($code)
    {
        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('applications')
            ->where('event_code', '=', $code)
            ->where(\DB::expr('not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)'))
            ->where('disable', '=', 0);

        $data = $total->execute('slave')->current();
        return $data['cnt'];
    }

    public static function lists($mode = null, $limit = null, $open = null, $secret = null, $sort="desc", $display=1, $username = null, $isend = null)
    {
        $select = '*, ';
        $select .= 'events.code, ';
        $select .= '(
                select 
                        count(*) 
                    from 
                        applications 
                    where 
                        applications.event_code = events.code and 
                        applications.disable = 0 and 
                        not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
                    ) as application_num';

        $datas = \DB::select(\DB::expr($select))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0);

        if ($username === null) {
        } else {
            $datas = $datas->where('events.username', '=', $username);
        }

        if ($display === null) {
        } else {
            $datas = $datas->where('display', '=', $display);
        }

        if ($secret === null) {
        } else {
            $datas = $datas->where('secret', '=', $secret);
        }

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open !== null) {
          $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($isend === null) {
          $datas = $datas->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        }

        $datas = $datas->order_by('event_date', $sort);

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute('slave')
            ->as_array();
        foreach($datas as $key => $data){
            $datas[$key]['applicable'] = self::is_applicable_by_event_date($data['event_date'], $data['event_start_datetime']);
            $datas[$key]['full'] = $data['application_num'] >= $data['limit'] ? true: false;

        }
        return $datas;
    }

    public static function listsnew($mode = null, $limit = null, $open = null, $secret = null, $sort="desc", $display=1, $username = null, $isend = null)
    {
        $select = '*, ';
        $select .= 'events.code, ';
        $select .= '(
                select 
                        count(*) 
                    from 
                        applications 
                    where 
                        applications.event_code = events.code and 
                        applications.disable = 0 and 
                        not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
                    ) as application_num';

        $datas = \DB::select(\DB::expr($select))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0);

        if ($username === null) {
        } else {
            $datas = $datas->where('events.username', '=', $username);
        }

        if ($display === null) {
        } else {
            $datas = $datas->where('display', '=', $display);
        }

        if ($secret === null) {
        } else {
            $datas = $datas->where('secret', '=', $secret);
        }

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($open !== null) {
          $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
        }

        if ($isend === null) {
          $datas = $datas->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        }

        $datas = $datas->order_by('open_date', $sort);

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute('slave')
            ->as_array();
        foreach($datas as $key => $data){
            $datas[$key]['applicable'] = self::is_applicable_by_event_date($data['event_date'], $data['event_start_datetime']);
            $datas[$key]['full'] = $data['application_num'] >= $data['limit'] ? true: false;

        }
        return $datas;
    }

    /**
     * 過去のイベント一覧取得
     * @param null $mode
     * @param null $limit
     * @param null $open
     * @param null $section_code
     * @param null $secret
     * @param int  $display
     * @param null $sort
     * @return mixed
     */
    public static function lists02($mode = null, $limit = null, $open = null, $section_code = null, $secret = null, $display=1, $sort="asc", $username = null)
    {
        $select = '*, ';
        $select .= 'events.code, ';
        $select .= '(
                select 
                        count(*) 
                    from 
                        applications 
                    where 
                        applications.event_code = events.code and 
                        applications.disable = 0 and
                        not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
                ) as application_num';
        $datas = \DB::select(\DB::expr($select))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->join(array(\DB::expr('select max(id) as id, username from diagnostic_chart_type_users group by username'), 'types'), 'LEFT')
            ->on('types.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0);

        if ($display === null) {
        } else {
            $datas = $datas->where('display', '=', $display);
        }

        if ($secret === null) {
        } else {
            $datas = $datas->where('secret', '=', $secret);
        }

        if ($mode === null) {
        } else {
            $datas = $datas->where('status', '=', $mode);
        }

        if ($username === null) {
        } else {
            $datas = $datas->where('events.username', '=', $username);
        }

//        if ($open === null) {
//        } else {
////            $datas = $datas->where('event_date', '<=', \DB::expr('NOW() - INTERVAL 1 DAY'));
//        }

        $datas = $datas->where('event_date', '<=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        $datas = $datas->order_by('event_date', $sort);

        if ($limit === null) {
        } else {
            $datas = $datas->limit($limit);
        }
        $datas = $datas->execute('slave')
            ->as_array();
        foreach($datas as $key => $data){
            $datas[$key]['applicable'] = self::is_applicable_by_event_date($data['event_date'], $data['event_start_datetime']);
            $datas[$key]['full'] = $data['application_num'] >= $data['limit'] ? true: false;
        }

        return $datas;
    }

    /**
     * 全イベント一覧取得
     * @param null $mode
     * @param null $limit
     * @param null $open
     * @param null $section_code
     * @param null $secret
     * @param int $display
     * @return mixed
     */
    public static function lists03($username = null)
    {
        $select = '*, ';
        $select .= 'events.code, ';

        $select .= '(
            select 
                    count(*) 
                from 
                    applications 
                where 
                    applications.event_code = events.code and 
                    applications.disable = 0 and 
                    not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
        ) as application_num';

        $datas = \DB::select(\DB::expr($select))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('events.disable', '=', 0)
            ->order_by('event_date', 'asc');

        if ($username === null) {
        } else {
            $datas = $datas->where('events.username', '=', $username);
        }

        return $datas->execute('slave');;
    }

    public static function create($params)
    {
        $data = array();

        $code = self::getNewCode('events');

        $data['incur_cancellation_fee_date'] = (!isset($params['incur_cancellation_fee_date']) || !$params['incur_cancellation_fee_date'])? '0000-00-00 00:00:00': $params['incur_cancellation_fee_date'];

        $data['event_category'] = $params['event_category'];
        $data['section_code'] = $params['section_code'];
        $data['secret'] = $params['secret'];
        $data['pr'] = $params['pr'];
        $data['display'] = $params['display'];
        $data['display_past'] = $params['display_past'];
        $data['specific_link'] = $params['specific_link'];
        $data['specific_application_link'] = $params['specific_application_link'];
        $data['title'] = $params['title'];
        $data['main_image'] = $params['main_image'];
        $data['content'] = $params['content'];
        $data['place'] = $params['place'];
        $data['place_url'] = $params['place_url'];
        $data['fee'] = $params['fee'];
        $data['display_event_date'] = $params['display_event_date'];
        $data['event_date'] = $params['event_date'];
        $data['event_start_datetime'] = $params['event_start_datetime'];
        $data['event_end_datetime'] = $params['event_end_datetime'];
        $data['creditch'] = $params['creditch'];
        $data['limit'] = (!$params['limit'])? 0: $params['limit'];
        $data['open_date'] = $params['open_date'];
        $data['status'] = $params['status'];
        $data['authentication_user'] = $params['authentication_user'];
        $data['authentication_password'] = $params['authentication_password'];
        $data['username'] = \Auth::get('username');
        $data['code'] = $code;
        $data['created_at'] = \DB::expr('now()');
        \DB::insert('events')->set($data)->execute();

        // リマインドメール
        $remind_mail = $params['remind_mail'];
        if ($remind_mail['subject'] && $remind_mail['body']) {
            \DB::insert('event_remind_mail_templates')
                ->set(array(
                    'event_code' => $code,
                    'subject'    => $remind_mail['subject'],
                    'body'       => $remind_mail['body'],
                    'status'     => $remind_mail['status'],
                    'created_at' => \DB::expr('now()'),
                ))
                ->execute();
        }

        // サンクスメール
        $thanks_mail = $params['thanks_mail'];
        if ($thanks_mail['subject'] && $thanks_mail['body']) {
            \DB::insert('event_thanks_mail_templates')
                ->set(array(
                    'event_code' => $code,
                    'subject'    => $thanks_mail['subject'],
                    'body'       => $thanks_mail['body'],
                    'status'     => $thanks_mail['status'],
                    'created_at' => \DB::expr('now()'),
                ))
                ->execute();
        }

        return $data;
    }

    public static function save($params)
    {
        $data = array();
        $data['incur_cancellation_fee_date'] = !$params['incur_cancellation_fee_date']? '0000-00-00 00:00:00': $params['incur_cancellation_fee_date'];

        $data['event_category'] = $params['event_category'];
        $data['section_code'] = $params['section_code'];
        $data['secret'] = $params['secret'];
        $data['pr'] = $params['pr'];
        $data['display'] = $params['display'];
        $data['display_past'] = $params['display_past'];
        $data['specific_link'] = $params['specific_link'];
        $data['specific_application_link'] = $params['specific_application_link'];
        $data['title'] = $params['title'];
        $data['main_image'] = $params['main_image'];
        $data['content'] = $params['content'];
        $data['place'] = $params['place'];
        $data['place_url'] = $params['place_url'];
        $data['fee'] = $params['fee'];
        $data['display_event_date'] = $params['display_event_date'];
        $data['event_date'] = $params['event_date'];
        $data['event_start_datetime'] = $params['event_start_datetime'];
        $data['event_end_datetime'] = $params['event_end_datetime'];
        $data['creditch'] = $params['creditch'];
        $data['limit'] = (!$params['limit'])? 0: $params['limit'];
        $data['open_date'] = $params['open_date'];
        $data['status'] = $params['status'];
        $data['authentication_user'] = $params['authentication_user'];
        $data['authentication_password'] = $params['authentication_password'];
        $data['username'] = \Auth::get('username');
        $data['updated_at'] = \DB::expr('now()');

        \DB::update('events')->set($data)->where('code', '=', $params['code'])->execute();

        // リマインドメール
        $remind_mail = $params['remind_mail'];
        if (!$remind_mail['subject'] || !$remind_mail['body']) {
            \DB::delete('event_remind_mail_templates')->where('event_code', '=', $params['code'])->execute();
        } else {
            if(\DB::select()->from('event_remind_mail_templates')->where('event_code', $params['code'])->execute()->current()) {
                \DB::update('event_remind_mail_templates')
                    ->set(array(
                        'subject'    => $remind_mail['subject'],
                        'body'       => $remind_mail['body'],
                        'status'     => $remind_mail['status'],
                        'updated_at' => \DB::expr('now()'),
                    ))
                    ->where('event_code', '=', $params['code'])
                    ->execute();
            } else {
                \DB::insert('event_remind_mail_templates')
                    ->set(array(
                        'event_code' => $params['code'],
                        'subject'    => $remind_mail['subject'],
                        'body'       => $remind_mail['body'],
                        'status'     => $remind_mail['status'],
                        'created_at' => \DB::expr('now()'),
                    ))
                    ->execute();
            }
        }

        // サンクスメール
        $thanks_mail = $params['thanks_mail'];
        if (!$thanks_mail['subject'] || !$thanks_mail['body']) {
            \DB::delete('event_thanks_mail_templates')->where('event_code', '=', $params['code'])->execute();
        } else {
            if(\DB::select()->from('event_thanks_mail_templates')->where('event_code', $params['code'])->execute()->current()) {
                \DB::update('event_thanks_mail_templates')
                    ->set(array(
                        'subject'    => $thanks_mail['subject'],
                        'body'       => $thanks_mail['body'],
                        'status'     => $thanks_mail['status'],
                        'updated_at' => \DB::expr('now()'),
                    ))
                    ->where('event_code', '=', $params['code'])
                    ->execute();
            } else {
                \DB::insert('event_thanks_mail_templates')
                    ->set(array(
                        'event_code' => $params['code'],
                        'subject'    => $thanks_mail['subject'],
                        'body'       => $thanks_mail['body'],
                        'status'     => $thanks_mail['status'],
                        'created_at' => \DB::expr('now()'),
                    ))
                    ->execute();
            }
        }

        return $data;
    }

    public static function delete($params)
    {
        \DB::update('events')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();

        return $params;
    }

    public static function updateDisplayPast($code, $display_past)
    {
        \DB::update('events')
            ->set(array('display_past' => $display_past))
            ->where('code', '=', $code)
            ->execute();
    }

    /**
     * 過去イベントかどうか判定する
     * @param $code イベントコード
     * @return bool 過去のイベントの場合: true, 過去のイベントじゃない場合: false
     */
    public static function isPast($code)
    {
        $result = \DB::select()
            ->from('events')
            ->where('events.code', '=', $code)
            ->where('event_date', '<', \DB::expr('NOW()'))
            ->execute('slave')
            ->current();
        if (empty($result)) {
            return false;
        }
        return true;
    }

    public static function all($section_code = null, $pagination_url, $page, $uri_segment = 3, $per_page = 5, $secret = null, $past = null, $sort='asc')
    {
        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->where('status', '=', 1)
            ->where('display', '=', 1)
            ->from('events')
            ->where('disable', '=', 0);

        if ($past === null) {
            $total = $total->where('open_date', '<', \DB::expr('NOW()'));
        } else if ($past === 0) {
            $total = $total->where('display_past', '=', 1);
            $total = $total->where('event_date', '<', \DB::expr('NOW()'));
        }

        if ($section_code !== null) {
            $total = $total->where('section_code', '=', $section_code);
        }
        if ($secret !== null) {
            $total = $total->where('secret', '=', $secret);
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

        $select = 'events.*, ';
        $select .= '(
                select 
                        count(*) 
                    from 
                        applications 
                    where 
                        applications.event_code = events.code and 
                        applications.disable = 0 and 
                        not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
                ) as application_num';

        $datas['datas'] = \DB::select(\DB::expr($select))
            ->from('events')
            ->join('profiles', 'left')
            ->on('events.username', '=', 'profiles.username')
            ->where('status', '=', 1)
            ->where('display', '=', 1)
            ->where('events.disable', '=', 0);

        if ($past === null) {
            $datas['datas'] = $datas['datas']->where('open_date', '<', \DB::expr('NOW()'));
            $datas['datas'] = $datas['datas']->where('event_date', '>=', \DB::expr('NOW() - INTERVAL 1 DAY'));
        } else if ($past === 0) {
            $datas['datas'] = $datas['datas']->where('display_past', '=', 1);
            $datas['datas'] = $datas['datas']->where('event_date', '<', \DB::expr('NOW()'));
        }

        if ($section_code !== null) {
            $datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
        }
        if ($secret !== null) {
            $datas['datas'] = $datas['datas']->where('secret', '=', $secret);
        }

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->order_by('event_date', $sort)
            ->execute('slave')
            ->as_array();
        foreach($datas['datas'] as $key => $data){
            $datas['datas'][$key]['applicable'] = self::is_applicable_by_event_date($data['event_date'], $data['event_start_datetime']);
            $datas['datas'][$key]['full'] = $data['application_num'] >= $data['limit'] ? true: false;
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
            ->execute('slave')->current();
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
        return self::is_applicable_by_event_date($event['event_date'], $event['event_start_datetime']);
    }

    private static function is_applicable_by_event_date($event_date, $start_time)
    {
        $applicableTime = strtotime(date('Y-m-d ' . $start_time . ':00', strtotime($event_date)));
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

    /**
     * 新規登録時のデフォルトの本文を取得
     * @return string
     */
    public static function getDefaultContent()
    {
        return '<p>金融ワカラナイ度：はじめてさん＆ゆる〜くお話したい方🌟🌟🌟🌟<br>スタイル：〜ゲストと交流しながらテーマについて考えるスタイル〜</p>
<h2>どんなことを学ぶ？</h2>
<p>100文字〜200文字
</p>
<p>＜写真＞</p>
<h2>今回のゲストは？</h2>
<p>200文字</p>
<p>＜写真＞</p>
<h2>女子会概要</h2>
<p>■日時<br>2019年9月12日（木）</p>
<p><br></p>
<p>■場所</p>
<p>オンライン（お申し込みいただいた方にURLをお知らせいたします）</p>
<p><br></p>
<p>■ゲスト</p>
<p><br></p>
<p>■人数</p>
<p><br></p>
<p>■参加費</p>
<p>
○○○○円（メンバーさんはギフトコードマッチで○○○円）<br>
OMC（オフィシャルメンバーズクラブ）の方はFREEです♪<br>
メルマガやインスタからギフトコードをチェックくださいね。
</p>
<p><br></p>
<p>■当日のスケジュール<br>19:00〜「きんゆう女子。」コミュニティのご紹介<br>19:10〜自己紹介<br>19:30〜ゲストのお話<br>20:00〜おしゃべり&ワーク<br>20:30〜感想とまとめ、自由解散<br>※スケジュールは予告なく変更になる場合がございます。予めご了承ください。</p>
<p><br></p>
<p>■持ち物</p>
<p>メモできる紙とペン✏️</p>
<p><br></p>
<p>■遅刻・欠席について<br>ログインして<a href="https://kinyu-joshi.jp/my">マイページ</a>からまたは、<a href="https://kinyu-joshi.jp/contact">お問い合わせ</a>からお知らせください。</p>
<h2>コミュニティからのお約束</h2>
<p>どの金融機関にも属さないポジションで、質の高いお金の情報を多角的にシェアできる場を提供します。
必要なことを必要なだけまとめた資料を用意、シェアいたします。女子会を通じた営業・勧誘はありません。また、ご参加いただく方同士でも営業・勧誘はお断りさせていただいております。マナーを守ってご参加いただければと思います。お困りのことがあれば「<a href="https://kinyu-joshi.jp/contact">サポートデスク</a>」までお問い合わせください。</p>
<p><br></p>
<p>主催：金融ワカラナイ女子のためのコミュニティ「きんゆう女子。」<br>お問い合わせ先：support@kinyu-joshi.jp</p>';
    }
}
