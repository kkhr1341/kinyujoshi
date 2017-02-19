<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Kuchikomi extends Base {


  public static function create($params) {
  
    $code = self::getNewCode('kuchikomi');
    //$params['created_at'] = \DB::expr('now()');
    //$params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
    \DB::insert('kuchikomi')->set($params)->execute();
  
    $email03 = \Email::forge('jis');
    $email03->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email03->subject("【きんゆう女子。】ワカラナイ口コミがありました");

    $nickname = $params['nickname'];
    $message = $params['message'];

    $email03->html_body(\View::forge('email/kuchikomi/body',
      array(
        'nickname' => $nickname,
        'message' => $message, 
      )));
    $email03->to('cs@kinyu-joshi.jp'); //送り先
    $email03->send();
    
    return $params;
  }

  public static function lists($mode = null, $limit = null) {
    
    $datas = \DB::select('*')->from('kuchikomi');
    // 　->join('profiles', 'left')
    //   ->on('news.username', '=', 'profiles.username')
    // 　->where('news.disable', '=', 0);

    // if ($mode === null) {
    // }
    // else {
    //   $datas = $datas->where('status', '=', $mode);
    // }
    
    // if ($open === null) {
    // }
    // else {
    //   $datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
    // }
    
    // if ($section_code === null) {
    // }
    // else {
    //   $datas = $datas->where('section_code', '=', $section_code);
    // }
    
    $datas = $datas->order_by(\DB::expr('RAND()'));
    
    if ($limit === null) {
    }
    else {
      $datas = $datas->limit($limit);
    }
    
    $datas = $datas->execute()->as_array();
    return $datas;
  }
  
  
}