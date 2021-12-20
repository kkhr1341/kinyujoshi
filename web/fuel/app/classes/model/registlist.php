<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Registlist extends Base
{

    public static function validate($username="")
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');


        $val->add('code', '会員コード');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule( // login_validate
                function($email) use ($username) {

                    $select = \DB::select("email")
                        ->where('email', '=', \Str::lower($email))
                        ->from('users');
                    if ($username) {
                        $select->where('username', '<>', $username);
                    }
                    $result = $select->execute();

                    if ($result->count() > 0) {
                        \Validation::active()->set_message('closure', 'このメールアドレスですでにメンバー登録がされているようです。');
                        return false;
                    } else {
                        return true;
                    }
                });

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('name_kana', 'ふりがな')
            ->add_rule('required');

        $val->add('official_member_job', 'オフィシャルメンバー職業');

        $val->add('birthday', '生年月日')
            ->add_rule('required')
            ->add_rule('mb_convert_kana', 'a', 'utf-8')
            ->add_rule('valid_date');

        $val->add('password', 'パスワード')
            ->add_rule('trim')
            ->add_rule('max_length', 255)
            ->add_rule('alphanum');

        if (!$username) {
            $val->field('password')
                ->add_rule('required');
        }

        $val->add('url', '「個人で発信しているブログなど」');

        $val->add('introduction', '自己紹介');

        $val->add('job_kind', '金融機関で働いていたり、仕事上金融に関わっていますか？');

        $val->add('edit_inner', '編集部入力欄(備考)');

        return $val;
    }

    public static function member_attribute_count($attr, $options)
    {
        if ($attr == 'age') {
            $attr = 'birthday';
            $attr_name = 'TIMESTAMPDIFF(YEAR, `birthday`, CURDATE())';
        } else {
            $attr_name = $attr;
        }

        $select = \DB::select(\DB::expr($attr_name . ' as label, count(' . $attr_name . ') as cnt'))
            ->from('member_regist')
            ->join('users', 'left')
            ->on('users.username', '=', 'member_regist.username')
            ->join('profiles', 'left')
            ->on('profiles.username', '=', 'users.username')
            ->join('prefectures', 'left')
            ->on('prefectures.code', '=', 'profiles.prefecture')
            ->where('member_regist.disable', '=', 1)
            ->where($attr, '!=', null)
            ->where($attr, '!=', '-')
            ->where($attr, '!=', '')
            ->group_by(\DB::expr($attr_name))
            ->order_by(\DB::expr('count(' . $attr_name . ')'), 'desc');

        if ($attr == 'age') {
            $select->where(\DB::expr('DAYOFYEAR(cast(birthday as date)) IS NOT NULL'));
        }

        if (isset($options['start_at']) && $options['start_at']) {
            $select->where('member_regist.created_at', '>=', $options['start_at'] . ' 00:00:00');
        }

        if (isset($options['end_at']) && $options['end_at']) {
            $select->where('member_regist.created_at', '<=', $options['end_at'] . ' 23:59:59');
        }

        if (isset($options['event_code']) && $options['event_code']) {
            $select->where(\DB::expr('exists(select * from applications where applications.username = users.username and applications.event_code = "' .  $options['event_code']. '")'));
        }

        if (!$row = $select->execute('slave')->as_array()) {
            return array();
        }
        return $row;
    }

    public static function create($params)
    {
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

            $profile = array(
                'code' => $profile_code,
                'username' => $username,
                'name' => $params['name'],
                'name_kana' => $params['name_kana'],
                'nickname' => $params['name'],
                'prefecture' => '',
                'url' => isset($params['url']) ? $params['url']: '',
                'introduction' => isset($params['introduction']) ? $params['introduction']: '',
            );

            if (isset($params["official_member_job"]) && $params["official_member_job"]) {
                $profile["official_member_job"] = $params["official_member_job"];
            }

            if (isset($params["profile_image"]) && $params["profile_image"]) {
                $profile["profile_image"] = $params["profile_image"];
            } else {
                $profile["profile_image"] = '';
            }

            if (isset($params["birthday"]) && $params["birthday"]) {
                $profile["birthday"] = $params["birthday"];
            } else {
                $profile["birthday"] = '';
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
                'name_kana' => $params['name_kana'],
                'email' => '',
                'url' => isset($params['url'])? $params['url']: '',
                'age' => $params['birthday'],
                'edit_inner' => isset($params['edit_inner']) ? $params['edit_inner']: '',
                'introduction' => isset($params['introduction']) ? $params['introduction']: '',
                'interest' => '',
                'ask' => '',
                'income' => '',
                'industry' => '',
                'industry_other' => '',
                'created_at' => \DB::expr('now()'),
                'user_agent' => @$_SERVER['HTTP_USER_AGENT'],
            ))->execute();

            $db->commit_transaction();

        } catch (Exception $e) {
            $db->rollback_transaction();
            \Log::error('register error::' . $e->getMessage());
            throw $e;
        }

        return $params;
    }

    public static function save($params)
    {

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {

            \DB::update('member_regist')->set(array(
                'name' => $params['name'],
                'name_kana' => $params['name_kana'],
                'age' => $params['birthday'],
                'url' => $params['url'],
                'introduction' => $params['introduction'],
                'edit_inner' => $params['edit_inner'],
                'job_kind' => $params['job_kind'],
            ))->where('code', '=', $params['code'])->execute();

            if ($username = self::getUsername($params['code'])) {

                // メールアドレスの変更確認
                \DB::update('users')->set(array(
                    'email' => $params['email']
                ))->where('username', '=', $username)->execute();

                $profile = array(
                    'name' => $params['name'],
                    'name_kana' => $params['name_kana'],
                    'birthday' => $params['birthday'],
                    'url' => $params['url'],
                );

                if (isset($params["official_member_job"]) && $params["official_member_job"]) {
                    $profile["official_member_job"] = $params["official_member_job"];
                }

                \DB::update('profiles')
                    ->set($profile)
                    ->where('username', '=', $username)
                    ->execute();

                if ($params['password']) {
                    $old_password = \Auth::reset_password($username);
                    \Auth::change_password($old_password, $params['password'], $username);
                }
            }

            $db->commit_transaction();

        } catch (Exception $e) {
            $db->rollback_transaction();
            \Log::error('register error::' . $e->getMessage());
            throw $e;
        }

        return $params;
    }

    public static function delete($params)
    {

        \DB::delete('member_regist')
            ->where(array('code' => $params['code']))
            ->execute();

        return $params;
    }

    public static function getUsername($code)
    {
        $result = \DB::select('users.username')
            ->from('member_regist')
            ->where('code', '=', $code)
            ->join('users')
            ->on('member_regist.username', '=', 'users.username')
            ->execute('slave')
            ->current();
        if (empty($result)) {
            return false;
        }
        return $result['username'];
    }
}
