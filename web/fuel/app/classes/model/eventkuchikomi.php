<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Eventkuchikomi extends Base {


  public static function create($params) {
    $code = self::getNewCode('event_kuchikomi');
    $params['username'] = \Auth::get('username');
    $params['code'] = $code;
    $params['created_at'] = \DB::expr('now()');
    \DB::insert('event_kuchikomi')->set($params)->execute();

    //email
    $email03 = \Email::forge('jis');
    $email03->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email03->subject("『きんゆう女子。』イベント記事への口コミがありました。");

    $message = $params['message'];

    $email03->html_body(\View::forge('email/eventkuchikomi/body',
      array(
        'message' => $message, 
      )));
    //$email03->to('cs@kinyu-joshi.jp'); //送り先
    $email03->to('komori@toetheline.jp');
    $email03->send();
    return $params;
  }
    
  public static function save($params) {
    $username = \Auth::get('username');
    //$params['main_image'] = self::get_main_image($params);
    \DB::update('event_kuchikomi')->set($params)->where('code', '=', $params['code'])->execute();    
    return $params;
  }
    
  public static function delete($params) {
    $username = \Auth::get('username');
    \DB::update('event_kuchikomi')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();    
    return $params;
  }

  public static function lists($mode = null, $limit = null) {
    $eventurl = $_SERVER["REQUEST_URI"];
    $eventurl01 = explode("/", $eventurl);
    $eventurl02 = $eventurl01[2];

    $datas = \DB::select('*')->from('event_kuchikomi')
    //->on('event_kuchikomi.event_code', '=', $eventurl02)
    ->where('disable', '=', 0)
    ->where('status', '=', 0)
    ->where('event_code', '=', $eventurl02);

    //イベントIDが1のものを除外する処理
    foreach ($datas as $key => $value) {
      if($datas[$key]->event_code == $eventurl02) {
        unset($datas[$key]);
      }
    }

    //$datas = $datas->order_by(\DB::expr('RAND()'));
    $datas = $datas->order_by('event_kuchikomi.id', 'desc');

    if ($limit === null) {
    }
    else {
      $datas = $datas->limit($limit);
    }
    
    $datas = $datas->execute()->as_array();
    return $datas;
  }
  
  public static function lists02($mode = null, $limit = null, $open = null) {
    
    $datas = \DB::select(\DB::expr('*, event_kuchikomi.code'))->from('event_kuchikomi')
    //->join('profiles', 'left')
    //->on('events.username', '=', 'profiles.username')
    ->where('event_kuchikomi.disable', '=', 0);

    if ($mode === null) {
    }
    else {
      $datas = $datas->where('status', '=', $mode);
    }
    
    if ($open === null) {
    }
    else {
      $datas = $datas->where('created_at', '<', \DB::expr('NOW()'));
    }
    
    // if ($section_code === null) {
    // }
    // else {
    //   $datas = $datas->where('section_code', '=', $section_code);
    // }
    
    $datas = $datas->order_by('event_kuchikomi.id', 'desc');
    
    if ($limit === null) {
    }
    else {
      $datas = $datas->limit($limit);
    }
    $datas = $datas->execute()
        ->as_array();
    return $datas;
  }
  
}