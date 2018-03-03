<?php

use \Model\Profiles;
use \Model\UserReminder;
use \Model\RegistReminder;
use \Model\MemberRegist;

class Controller_Login extends Controller_KinyuBase
{

    public function action_index()
    {

        if (!Auth::check()) {
            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
            $this->template->title = 'ログイン｜きんゆう女子。';
            $this->template->description = 'ログイン｜きんゆう女子';
            $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
            $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

            if (Agent::is_mobiledevice()) {
                $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
                $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
            } else {
            }
            $this->template->contents = View::forge('login/index.smarty', $this->data);

        } else {
            Response::redirect('/my');
        }
    }

    public function action_regist()
    {

        if (!Auth::check()) {
            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
            $this->template->title = 'ログイン｜きんゆう女子。';
            $this->template->description = 'ログイン｜きんゆう女子';
            $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
            $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

            if (Agent::is_mobiledevice()) {
                $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
                $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
            }
            $this->template->contents = View::forge('login/regist.smarty', $this->data);

        } else {
            Response::redirect('/my');
        }
    }

    public function action_regist_email()
    {
        if (!Auth::check()) {
            // ログイン後URL
            if ($after_login_url = \Session::get('after_login_url')) {
                \Session::set('after_login_url', '');
            }
            $this->template->after_login_url = $after_login_url;

            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
            $this->template->title = 'ログイン｜きんゆう女子。';
            $this->template->description = 'ログイン｜きんゆう女子';
            $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
            $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

            if (Agent::is_mobiledevice()) {
                $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
                $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
            }
            $this->template->contents = View::forge('login/regist_email.smarty', $this->data);
        } else {
            Response::redirect('/my');
        }
    }

    public function action_regist_sns()
    {
        if (!Auth::check()) {
            // SNS経由で取得したUIDがSESSIONにあるか確認
            $userdata = \Session::get_flash('userdata');
            if (!$userdata['uid']) {
                Response::redirect('/login');
            }
            $this->data['userdata'] = $userdata;

            // ログイン後URL
            if ($after_login_url = \Session::get('after_login_url')) {
                \Session::set('after_login_url', '');
            }
            $this->template->after_login_url = $after_login_url;

            $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
            $this->template->title = 'ログイン｜きんゆう女子。';
            $this->template->description = 'ログイン｜きんゆう女子';
            $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
            $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
            $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
            $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

            if (Agent::is_mobiledevice()) {
                $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
                $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
            }
            $this->template->contents = View::forge('login/regist_sns.smarty', $this->data);
        } else {
            Response::redirect('/my');
        }
    }

    public function action_resetting_pass()
    {
        // トークンチェック
        if (!$reminder = UserReminder::get_valid(\Input::get('access_token'))) {
            Response::redirect('/login');
        }
        $profile = Profiles::get($reminder['username']);
        $this->template->nickname = $profile['nickname'];
        $this->template->access_token = $reminder['access_token'];

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->title = 'パスワード再発行｜きんゆう女子。';
        $this->template->description = 'パスワード再発行｜きんゆう女子';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        }
        $this->template->contents = View::forge('login/resetting_pass.smarty', $this->data);
    }

    public function action_resetting_pass_exuser()
    {
        if (Auth::check()) {
            Response::redirect('/my');
        }
        // トークンチェック
        if (!$reminder = RegistReminder::get_valid(\Input::get('access_token'))) {
            Response::redirect('/login');
        }

        $member_regist = \DB::select('*')->from('member_regist')
                ->where('id', '=', $reminder['member_regist_id'])
                ->execute()->current();

        $this->template->nickname = $member_regist['name'];
        $this->template->email = $member_regist['email'];
        $this->template->access_token = $reminder['access_token'];

        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->title = 'パスワード再発行｜きんゆう女子。';
        $this->template->description = 'パスワード再発行｜きんゆう女子';
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        }
        $this->template->contents = View::forge('login/resetting_pass_exuser.smarty', $this->data);
    }

    public function action_complete()
    {
        $this->template->title = 'メンバー登録ありがとうございます！｜きんゆう女子。';
        $this->template->description = '';
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        //$this->template->today = date("Y年n月");
        $this->template->sp_header = View::forge('kinyu/common/sp_header.smarty', $this->data);
        $this->template->pc_header = View::forge('kinyu/common/pc_header.smarty', $this->data);
        $this->template->sp_footer = View::forge('kinyu/common/sp_footer.smarty', $this->data);
        $this->template->sp_navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);

        if (Agent::is_mobiledevice()) {
            $this->template->navigation = View::forge('kinyu/common/sp_navigation.smarty', $this->data);
            $this->template->sp_top_after = View::forge('kinyu/common/sp_top_after.smarty', $this->data);
        }
        $this->template->contents = View::forge('login/complete.smarty', $this->data);

    }
}