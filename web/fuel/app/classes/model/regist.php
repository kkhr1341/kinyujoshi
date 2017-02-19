<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Regist extends Base {


  public static function create($params) {
  
    $code = self::getNewCode('member_regist');
    $params['username'] = \Auth::get('username');
    $params['code'] = $code;
    $params['created_at'] = \DB::expr('now()');
    $params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
    \DB::insert('member_regist')->set($params)->execute();
  
    $email = \Email::forge('jis');
    $email->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email->subject("【きんゆう女子。】メンバー登録ありがとうございます(*^^*)");

    $name = $params['name'];

    $email->html_body(\View::forge('email/regist/body',
      array(
        'name' => $name
      )));
    $email->to($params['email']); //送り先
    $email->send();

    $email02 = \Email::forge('jis');
    $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email02->subject("【きんゆう女子。】メンバー登録がありました！");

    $name = $params['name'];
    $age = $params['age'];
    $not_know = $params['not_know'];
    $interest = $params['interest'];
    $ask = $params['ask'];
    $income = $params['income'];
    $transmission = $params['transmission'];
    $email = $params['email'];
    $facebook = $params['facebook'];
    $other_sns = $params['other_sns'];
    $introduction = $params['introduction'];
    
    $email02->html_body(\View::forge('email/regist/return', 
      array(
        'name' => $name,
        'age' => $age,
        'not_know' => $not_know,
        'interest' => $interest,
        'ask' => $ask,
        'income' => $income,
        'transmission' => $transmission, 
        'email' => $email,
        'facebook' => $facebook,
        'other_sns' => $other_sns,
        'introduction' => $introduction
      )));
    $email02->to('cs@kinyu-joshi.jp'); //送り先
    $email02->send();
    
    return $params;
  }

  public static function lists() {
    \DB::set_charset('utf8');
    $datas = \DB::select('*')->from('member_regist')->execute()->as_array();
    header('Content-type: text/html; charset=UTF-8'); 
    //var_dump($datas);
    //$result = \DB::query('show variables like \'character\_set\_%\';', \DB::SELECT)->execute()->as_array();
    //var_dump($result);
    return $datas;
  }

  public static function getByCodeWithurl($code) {
  $result = \DB::select('*')->from('member_regist')
       ->where('member_regist.code', '=', $code)
       ->execute()->current();
  if (empty($result)) {
   return false;
  }
  return $result;
  }

}
