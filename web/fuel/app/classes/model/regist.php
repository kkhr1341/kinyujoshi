<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Regist extends Base {

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule('unique', array(
                'table' => 'users',
                'field' => 'email',
            ));

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('name_kana', 'ふりがな')
            ->add_rule('required');

        $val->add('birthday', '生年月日')
            ->add_rule('mb_convert_kana', 'a', 'utf-8')
            ->add_rule('valid_date');

        $val->add('profile_image', 'プロフィール画像');

        $val->add('provider');
        $val->add('uid');

        $val->add('password', 'パスワード')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 255)
            ->add_rule('alphanum');


        $val->add('not_know', 'きんゆうワカラナイ度')
            ->add_rule('required');

        $val->add('interest', '「お金について知りたいこと・興味のあること」')
            ->add_rule('required');

        $val->add('ask', '「きんゆう女子。でどんな出会いや発見がほしいですか？」')
            ->add_rule('required');

        $val->add('income', '「3年後の自分の年収をどのくらいにしたいですか？」')
            ->add_rule('required');

        $val->add('where_from', '「どこできんゆう女子。を知りましたか？」')
            ->add_rule('required');

        $val->add('where_from_other', '「どこできんゆう女子。を知りましたか？その他」');

        $val->add('transmission', '「きんゆう女子。で情報発信したいですか？」')
            ->add_rule('required');

        $val->add('url', '「個人で発信しているブログなど」');

        $val->add('job_kind', '「金融機関で働いていますか？」')
            ->add_rule('required');

        $val->add('introduction', '自己紹介')
            ->add_rule('required');

//        $val->add('confirm_password', 'パスワード（確認用）')
//            ->add_rule('trim')
//            ->add_rule('match_validated_field', 'password')
//            ->set_error_message('match_validated_field', 'パスワード（確認用）は、パスワードと異なっています');

        return $val;
    }

    public static function create($params) {

      $db = \Database_Connection::instance();
      $db->start_transaction();
      try {
          $username = \Str::random('alnum', 16);
          $user_id = \Auth::create_user(
              $username,
              $params["password"],
              $params["email"],
              1
          );

          // プロフィール登録
          $profile_code = Profiles::getNewCode('profiles', 6);

          $profile = [
              'code' => $profile_code,
              'username' => $username,
              'name' => $params['name'],
              'name_kana' => $params['name_kana'],
              'nickname' => $params['name'],
              'email' => $params['email'],
              'birthday' => $params['birthday'],
//              'gender' => $params['gender']
          ];

          if (isset($params["profile_image"]) && $params["profile_image"]) {
              $profile["profile_image"] = $params["profile_image"];
          } else {
              $profile["profile_image"] = '';
          }

          Profiles::create($profile);

          // call Opauth to link the provider login with the local user
          if (isset($params['provider']) && $params['provider']) {
              $opauth = \Auth_Opauth::forge(false);
              $opauth->link_provider(array(
                  'parent_id' => $user_id,
                  'provider' => $params['provider'],
                  'uid' => $params['uid'],
                  'access_token' => $params['provider'],
//              'secret' => $params['provider'],
                  'expires' => $params['provider'],
//              'refresh_token' => $params['provider'],
                  'created_at' => time()
              ));
          }

          $code = self::getNewCode('member_regist');
          \DB::insert('member_regist')->set(array(
              'code' => $code,
              'username' => $username,
              'name' => $params['name'],
              'not_know' => $params['not_know'],
              'interest' => $params['interest'],
              'ask' => $params['ask'],
              'email' => $params['email'],
              'income' => $params['income'],
              'where_from' => $params['where_from'],
              'where_from_other' => $params['where_from_other'],
              'transmission' => $params['transmission'],
//              'facebook' => $params['facebook'],
              'job_kind' => $params['job_kind'],
              'introduction' => $params['introduction'],
              'age' => $params['birthday'],
              'edit_inner' => '',
              'industry' => '',
              'industry_other' => '',
              'created_at' => \DB::expr('now()'),
              'user_agent' => @$_SERVER['HTTP_USER_AGENT'],
          ))->execute();

          $db->commit_transaction();

          // ログイン
          \Auth::instance()->force_login((int)$user_id);
      } catch (Exception $e) {
          $db->rollback_transaction();
          \Log::error('register error::'.$e->getMessage());
          throw $e;
      }

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
    $name_kana = $params['name_kana'];
    $age = $params['age'];
    $not_know = $params['not_know'];
    $interest = $params['interest'];
    $ask = $params['ask'];
    $income = $params['income'];
    $where_from = $params['where_from'];
    $where_from_other = $params['where_from_other'];
    $transmission = $params['transmission'];
    $email = $params['email'];
    $facebook = $params['facebook'];
    $job_kind = $params['job_kind'];
    $introduction = $params['introduction'];
    
    $email02->html_body(\View::forge('email/regist/return', 
      array(
        'name' => $name,
        'name_kana' => $name_kana,
        'age' => $age,
        'not_know' => $not_know,
        'interest' => $interest,
        'ask' => $ask,
        'income' => $income,
        'where_from' => $where_from,
        'where_from_other' => $where_from_other,
        'transmission' => $transmission, 
        'email' => $email,
        'facebook' => $facebook,
        'job_kind' => $job_kind,
        'introduction' => $introduction
      )));
    $email02->to('cs@kinyu-joshi.jp'); //送り先
    $email02->send();
    
    return $params;
  }

  public static function save($params) {
    $username = \Auth::get('username');
    \DB::update('member_regist')->set($params)->where('code', '=', $params['code'])->execute();
    return $params;
  }

  public static function lists() {
    \DB::set_charset('utf8');
    $datas = \DB::select('*')->from('member_regist');
    $datas = $datas->order_by('created_at', 'desc');
    //$datas = $datas->array_unique($input);
    $datas = $datas->where('member_regist.disable', '=', 1)->execute()->as_array();
    header('Content-type: text/html; charset=UTF-8'); 
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

  public static function document($params) {
  
    $code = self::getNewCode('document_company');
    //$params['username'] = \Auth::get('username');
    $params['code'] = $code;
    $params['created_at'] = \DB::expr('now()');
    //$params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
    \DB::insert('document_company')->set($params)->execute();
    $email03 = \Email::forge('jis');
    $email03->from("no-reply@kinyu-joshi.jp", ''); //送り元
    $email03->subject("【きんゆう女子。】第1回 週末投資宣言♪の資料がDLされました。");
    
    $name = $params['name'];
    $company = $params['company'];
    $email = $params['email'];
    
    $email03->html_body(\View::forge('email/document/return', 
      array(
        'name' => $name,
        'company' => $company,
        'email' => $email
      )));
    $email03->to('cs@kinyu-joshi.jp'); //送り先
    $email03->send();
    
    return $params;
  }

}
