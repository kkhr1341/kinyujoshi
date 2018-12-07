<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class Regist extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('email', 'メールアドレス')
            ->add_rule('required')
            ->add_rule( // login_validate
                function($email) {
                    $select = \DB::select("email")
                        ->where('email', '=', \Str::lower($email))
                        ->from('users');
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

        $val->add('birthday', '生年月日')
            ->add_rule('mb_convert_kana', 'a', 'utf-8')
            ->add_rule('valid_date');

        $val->add('prefecture', '都道府県')
            ->add_rule('required');

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

        $val->add('job_kind', '金融機関で働いていたり、仕事上金融に関わっていますか？')
            ->add_rule('required');

        $val->add('want_to_learns', 'きんゆう女子。コミュニティで何を学んだり知りたい？')
            ->add_rule('required');

        $val->add('want_to_meets', 'きんゆう女子。コミュニティではどんな発見や出会いがほしい？')
            ->add_rule('required');

        $val->add('want_to_something', '金融に向き合い学び、3年後には何がほしいですか？')
            ->add_rule('required');

//        $val->add('income', '「3年後の自分の年収をどのくらいにしたいですか？」')
//            ->add_rule('required');

        $val->add('where_from', '「どこできんゆう女子。を知りましたか？」')
            ->add_rule('required');
        $val->add('where_from_site', '良かったらサイト名を教えてください♪');
        $val->add('where_from_other', '「どこできんゆう女子。を知りましたか？その他」');

        $val->add('regist_triggers', 'メンバーになろうと思ったきっかけ')
            ->add_rule('required');

        $val->add('future', 'きんゆう女子。を通してどんな自分になりたい？')
            ->add_rule('required');

        $val->add('transmission', 'きんゆう女子。で情報発信したいですか？')
            ->add_rule('required');

        $val->add('url', '「個人で発信しているブログなど」');

        $val->add('introduction', '自己紹介')
            ->add_rule('required');

        return $val;
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
                'birthday' => $params['birthday'],
                'prefecture' => $params['prefecture'],
                'url' => $params['url'],
                'introduction' => $params['introduction'],
//              'gender' => $params['gender']
            );

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
                'name_kana' => $params['name_kana'],
                'not_know' => $params['not_know'],
                'interest' => '',
                'ask' => '',
                'email' => '',
                'income' => '',
                'where_from' => $params['where_from'],
                'where_from_site' => $params['where_from_site'],
                'where_from_other' => $params['where_from_other'],
                'want_to_something' => $params['want_to_something'],
                'future' => $params['future'],
                'transmission' => $params['transmission'],
                'job_kind' => $params['job_kind'],
                'age' => $params['birthday'],
                'edit_inner' => '',
                'industry' => '',
                'industry_other' => '',
                'introduction' => $params['introduction'],
                'created_at' => \DB::expr('now()'),
                'user_agent' => @$_SERVER['HTTP_USER_AGENT'],
            ))->execute();

            if ($params['want_to_learns']) {
                foreach($params['want_to_learns'] as $value) {
                    \DB::insert('user_want_to_learns')->set(array(
                        'username' => $username,
                        'value' => $value,
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                }
            }

            if ($params['want_to_meets']) {
                foreach($params['want_to_meets'] as $value) {
                    \DB::insert('user_want_to_meets')->set(array(
                        'username' => $username,
                        'value' => $value,
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                }
            }

            if ($params['regist_triggers']) {
                foreach($params['regist_triggers'] as $value) {
                    \DB::insert('user_regist_triggers')->set(array(
                        'username' => $username,
                        'value' => $value,
                        'created_at' => \DB::expr('now()'),
                    ))->execute();
                }
            }

            $db->commit_transaction();

            // ログイン
            \Auth::instance()->force_login((int)$user_id);
        } catch (Exception $e) {
            $db->rollback_transaction();
            \Log::error('register error::' . $e->getMessage());
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

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("【きんゆう女子。】メンバー登録がありました！");

        $email02->html_body(\View::forge('email/regist/return', array()));
        $email02->to('cs@kinyu-joshi.jp'); //送り先

        $email02->return_path('support@kinyu-joshi.jp');
        $email02->send();

        return $params;
    }

    public static function save($params)
    {
//        $username = \Auth::get('username');
        \DB::update('member_regist')->set($params)->where('code', '=', $params['code'])->execute();
        return $params;
    }

    public static function total()
    {
        \DB::set_charset('utf8');
        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('member_regist')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'member_regist.username')
            ->where('member_regist.disable', '=', 1);

        $total = $total->execute()->current();
        return $total['cnt'];
    }
    public static function all($pagination_url, $page, $uri_segment = 3, $per_page = 5, $params)
    {
        \DB::set_charset('utf8');
        $total = \DB::select(\DB::expr('count(*) as cnt'))
            ->from('member_regist')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'member_regist.username')
            ->join('users', 'LEFT')
            ->on('users.username', '=', 'member_regist.username')
            ->where('member_regist.disable', '=', 1);

        if (isset($params['username']) && $params['username']) {
            $total->where('member_regist.username', $params['username']);
        }
        if (isset($params['name']) && $params['name']) {
            $total->where(\DB::expr("ifnull(profiles.name, member_regist.name)"), 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['email']) && $params['email']) {
            $total->where('member_regist.email', 'like','%' . $params['email'] . '%');
        }
        if (isset($params['introduction']) && $params['introduction']) {
            $total->where('member_regist.introduction', 'like', '%' . $params['introduction'] . '%');
        }
        if (isset($params['group']) && $params['group']) {
            $total->and_where_open()
                ->where('users.group', 'in', $params['group'])
                ->or_where('users.group', 'is', null)
                ->and_where_close();
        }

        $total = $total->execute()->current();
        $datas['total'] = $total['cnt'];

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
                "member_regist.id",
                "member_regist.code",
                "member_regist.username",
                "member_regist.age",
                "member_regist.not_know",
                "member_regist.interest",
                "member_regist.ask",
                "member_regist.income",
                "member_regist.transmission",
                "member_regist.email",
                "member_regist.facebook",
                "member_regist.other_sns",
                "member_regist.introduction",
                "member_regist.user_agent",
                "member_regist.where_from",
                "member_regist.where_from_other",
                "member_regist.job_kind",
                "member_regist.id_name",
                "member_regist.disable",
                "member_regist.edit_inner",
                "member_regist.industry",
                "member_regist.industry_other",
                "member_regist.created_at",
                "member_regist.updated_at",
                \DB::expr("exists(select * from users where users.username = member_regist.username) as is_user"),
                \DB::expr("ifnull(profiles.name, member_regist.name) as name"),
                \DB::expr("ifnull(profiles.name_kana, member_regist.name_kana) as name_kana"),
                \DB::expr("(select diagnostic_chart_types.type from diagnostic_chart_type_users inner join diagnostic_chart_types on diagnostic_chart_types.code = diagnostic_chart_type_users.type_code where diagnostic_chart_type_users.id = types.id) as type")
            )
            ->from('member_regist')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'member_regist.username')
            ->join('users', 'LEFT')
            ->on('users.username', '=', 'member_regist.username')
            ->join(array(\DB::expr('select max(id) as id, username from diagnostic_chart_type_users group by username'), 'types'), 'LEFT')
            ->on('types.username', '=', 'member_regist.username')
            ->where('member_regist.disable', '=', 1);

        if (isset($params['username']) && $params['username']) {
            $datas['datas']->where('member_regist.username', $params['username']);
        }
        if (isset($params['name']) && $params['name']) {
            $datas['datas']->where(\DB::expr("ifnull(profiles.name, member_regist.name)"), 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['email']) && $params['email']) {
            $datas['datas']->where('member_regist.email', 'like','%' . $params['email'] . '%');
        }
        if (isset($params['introduction']) && $params['introduction']) {
            $datas['datas']->where('member_regist.introduction', 'like', '%' . $params['introduction'] . '%');
        }
        if (isset($params['group']) && $params['group']) {
            $datas['datas']->and_where_open()
                ->where('users.group', 'in', $params['group'])
                ->or_where('users.group', 'is', null)
                ->and_where_close();
        }

        $datas['datas'] = $datas['datas']->limit($pagination->per_page)
            ->offset($pagination->offset)
            ->order_by('member_regist.created_at', 'desc')
            ->execute()
            ->as_array();
        $datas['pagination'] = $pagination;

        return $datas;
    }

    public static function lists()
    {
        \DB::set_charset('utf8');
        $datas = \DB::select(
            "member_regist.id",
            "member_regist.code",
            "member_regist.username",
            "member_regist.age",
            "member_regist.not_know",
            "member_regist.interest",
            "member_regist.ask",
            "member_regist.income",
            "member_regist.transmission",
            "member_regist.email",
            "member_regist.facebook",
            "member_regist.other_sns",
            "member_regist.introduction",
            "member_regist.user_agent",
            "member_regist.where_from",
            "member_regist.where_from_other",
            "member_regist.job_kind",
            "member_regist.id_name",
            "member_regist.disable",
            "member_regist.edit_inner",
            "member_regist.industry",
            "member_regist.industry_other",
            "member_regist.created_at",
            "member_regist.updated_at",
            \DB::expr("exists(select * from users where users.username = member_regist.username) as is_user"),
            \DB::expr("ifnull(profiles.name, member_regist.name) as name"),
            \DB::expr("ifnull(profiles.name_kana, member_regist.name_kana) as name_kana"),
            \DB::expr("prefectures.name as prefecture_name"),
            \DB::expr("(select diagnostic_chart_types.type from diagnostic_chart_type_users inner join diagnostic_chart_types on diagnostic_chart_types.code = diagnostic_chart_type_users.type_code where diagnostic_chart_type_users.id = types.id) as type")
        )
            ->from('member_regist')
            ->join('users', 'LEFT')
            ->on('member_regist.username', '=', 'users.username')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'member_regist.username')
            ->join('prefectures', 'LEFT')
            ->on('prefectures.code', '=', 'profiles.prefecture')
            ->join(array(\DB::expr('select max(id) as id, username from diagnostic_chart_type_users group by username'), 'types'), 'LEFT')
            ->on('types.username', '=', 'member_regist.username')
            ->where('member_regist.disable', '=', 1)
            ->and_where_open()
            ->where('users.group', 'in', array('1'))
            ->or_where('users.group', 'is', null)
            ->and_where_close();

        $datas = $datas->order_by('member_regist.created_at', 'desc');
        //$datas = $datas->array_unique($input);
        $datas = $datas->execute()->as_array();
//        header('Content-type: text/html; charset=UTF-8');
        return $datas;

    }

    public static function getByCodeWithurl($code)
    {
        $result = \DB::select(
            "member_regist.id", 
            "member_regist.code", 
            "member_regist.username", 
            "member_regist.age", 
            "member_regist.not_know",
            "member_regist.interest", 
            "member_regist.ask", 
            "member_regist.income", 
            "member_regist.transmission", 
            "member_regist.email", 
            "member_regist.facebook", 
            "member_regist.other_sns", 
            "member_regist.introduction", 
            "member_regist.user_agent", 
            "member_regist.where_from", 
            "member_regist.where_from_other", 
            "member_regist.job_kind", 
            "member_regist.id_name", 
            "member_regist.disable", 
            "member_regist.edit_inner", 
            "member_regist.industry", 
            "member_regist.industry_other", 
            "profiles.prefecture", 
            "member_regist.created_at", 
            "member_regist.updated_at",
            \DB::expr("prefectures.name as prefecture_name"),
            \DB::expr("ifnull(profiles.name, member_regist.name) as name"),
            \DB::expr("ifnull(profiles.name_kana, member_regist.name_kana) as name_kana")
            )
            ->from('member_regist')
            ->join('profiles', 'LEFT')
            ->on('profiles.username', '=', 'member_regist.username')
            ->join('prefectures', 'LEFT')
            ->on('prefectures.code', '=', 'profiles.prefecture')
            ->where('member_regist.code', '=', $code)
            ->execute()->current();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function document($params)
    {

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

        $email03->return_path('support@kinyu-joshi.jp');
        $email03->send();

        return $params;
    }

    public static function has_account($member_regist_code)
    {
        return \DB::select('*')
            ->from('member_regist')
            ->where('code', '=', $member_regist_code)
            ->where(\DB::expr('exists(select "x" from users where users.email = member_regist.email)'))
            ->execute()
            ->current();
    }
}
