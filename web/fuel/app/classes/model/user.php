<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class User extends Base
{
    public static function staff_edit_validate()
    {
      $val = \Validation::forge();
      $val->add_callable('myvalidation');

      $val->add('user_id', 'ID')
          ->add_rule('required');

      $val->add('group', '権限')
          ->add_rule('required');

      return $val;
    }

    public static function validate($username)
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule(
                function($email) use($username) {
                    $select = \DB::select("email")
                        ->where('email', '=', $email)
                        ->where('username', '<>', $username)
                        ->from('users');

                    $result = $select->execute();

                    if ($result->count() > 0) {
                        \Validation::active()->set_message('closure', 'このメールアドレスですでにメンバー登録がされているようです。');
                        return false;
                    } else {
                        return true;
                    }
                });

        $confirm_password = \Input::post('confirm_password');

        $val->add('new_password', '新しいパスワード')
            ->add_rule('trim')
            ->add_rule('min_length', 8)
            ->add_rule('max_length', 16)
            ->add_rule(
                function($new_password) use ($confirm_password) {
                    if ($new_password === $confirm_password) {
                        return true;
                    } else {
                        \Validation::active()->set_message('closure', 'ご確認用のパスワードが違うようです...。再度ご入力をお願いいたします。');
                        return false;
                    }
                });

        return $val;
    }

    public static function getByUserId($user_id)
    {
      $result = \DB::select('*')->from('users')
                                ->where('users.id', '=', $user_id)
                                ->execute('slave')->current();
      if (empty($result)) {
          return false;
      }
      return $result;
    }

    public static function getByEmail($email)
    {
        $result = \DB::select('*')->from('users')
            ->where('users.email', '=', $email)
            ->execute('slave')->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getByUserName($username)
    {
        $result = \DB::select('*')->from('users')
            ->where('users.username', '=', $username)
            ->execute('slave')->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function getPublishProfileUsers( $pagination_url, $page, $uri_segment = 3, $per_page = 5 )
    {
      $total = \DB::select(\DB::expr('count(*) as cnt'))->from('users')
                                                        ->join('profiles', 'inner')
                                                        ->on('profiles.username', '=', 'users.username')
                                                        ->where('profiles.publish', '=', 1)
                                                        ->where('profiles.disable', '=', 0)
                                                        ->execute('slave')->current();

      $pagination = \Pagination::forge('mypagination', array(
        'pagination_url' => $pagination_url,
        'total_items' => $total['cnt'],
        'per_page' => $per_page,
        'uri_segment' => $uri_segment,
        'current_page' => (int)$page,
        'name' => 'bootstrap',
        'wrapper' => '<ul class="pagination">{pagination}</ul>',
      ));

      $results = \DB::select_array(array('profiles.*', 'users.*'))->from('users')
                                 ->join('profiles', 'inner')
                                 ->on('profiles.username', '=', 'users.username')
                                 ->where('profiles.publish', '=', 1)
                                 ->where('profiles.disable', '=', 0);

      $results = $results->limit($pagination->per_page)
                         ->offset($pagination->offset)
                         ->order_by('profiles.updated_at', 'desc')
                         ->execute('slave')
                         ->as_array();

      $datas = array();
      $datas['users'] = $results;
      $datas['pagination'] = $pagination;

      return $datas;
    }

    public static function save($params, $username, $current_email)
    {
        // メールアドレスの変更確認
        \DB::update('users')->set(array(
            'email' => $params['email']
        ))->where('username', '=', $username)->execute();

        \DB::update('member_regist')->set(array(
            'email' => $params['email']
        ))->where('username', '=', $username)->execute();

        if ($params['new_password']) {
            $old_password = \Auth::reset_password($username);
            \Auth::change_password($old_password, $params['new_password'], $username);
        }

        // メールアドレスの変更通知を通知
        if ($current_email != $params['email']) {

            // 変更履歴
            \DB::insert('change_email_histories')->set(array(
                'username' => $username,
                'before_email' => $current_email,
                'after_email' => $params['email'],
            ))->execute();

            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】メールアドレス変更通知");

            $mail->attach(DOCROOT.'images/kinyu-logo.png', true);

            $mail->html_body(\View::forge('email/email_change_notify/return',
                array(
                    'username' => $username,
                    'before_email' => $current_email,
                    'after_email'  => $params['email'],
                )));
            $mail->to('support@kinyu-joshi.jp'); //送り先

            $mail->return_path('support@kinyu-joshi.jp');

            $mail->send();
        }

        return true;
    }

    public static function grant_update($params, $user_id)
    {
      \DB::update('users')->set(
        array(
          'group' => $params['group'],
        )
      )->where('id', '=', $user_id)->execute();
      return true;
    }


    public static function staff_list()
    {
        \Config::load('simpleauth', true);

        $datas = \DB::select(
                \DB::expr('users.*'),
                \DB::expr('profiles.name'),
                \DB::expr('profiles.name_kana')
            )
            ->from('users')
            ->join('profiles')
            ->on('users.username', '=', 'profiles.username');

        $datas = $datas->order_by('group', 'desc');
        $datas = $datas->order_by('id', 'asc');

        $users = $datas->execute('slave')->as_array();

        $groups = \Config::get('simpleauth.groups');

        foreach($users as $key => $user) {
            $group = $users[$key]['group'];
            $users[$key]['group_name'] = $groups[$group]['name'];
        }
        return $users;
    }

    public static function staff_detail($id)
    {
        \Config::load('simpleauth', true);

        $datas = \DB::select(
                \DB::expr('users.*'),
                \DB::expr('profiles.name'),
                \DB::expr('profiles.name_kana')
            )
            ->from('users')
            ->join('profiles')
            ->on('users.username', '=', 'profiles.username')
            ->where('users.id', '=', $id);

        $users = $datas->execute('slave')->as_array();
        $groups = \Config::get('simpleauth.groups');

        foreach($users as $key => $user) {
          $group = $users[$key]['group'];
          $users[$key]['group_name'] = $groups[$group]['name'];
        }

        return $users[0];
    }
}
