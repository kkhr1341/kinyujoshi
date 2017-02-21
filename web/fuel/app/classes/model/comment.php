<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Comment extends Base {


  public static function create($params) {
  
    $code = self::getNewCode('comment');
    $params['created_at'] = \DB::expr('now()');
    //$params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
    \DB::insert('comment')->set($params)->execute();
  
    $email = \Email::forge('jis');
    $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email->subject("【きんゆう女子。】編集部へのコメントがありました");

    $message = $params['message'];

    $email->html_body(\View::forge('email/comment/body',
      array(
        'message' => $message, 
      )));
    $email->to('cs@kinyu-joshi.jp'); //送り先
    $email->send();
    
    return $params;
  }

  public static function lists($mode = null, $limit = null) {
    
    $datas = \DB::select('*')->from('comment');
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