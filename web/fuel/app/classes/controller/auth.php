<?php

class Controller_Auth extends Controller
{
    public function action_oauth($provider = null)
    {
        // bail out if we don't have an OAuth provider to call
        if ($provider === null) {
            //\Messages::error(__('login-no-provider-specified'));
            \Response::redirect_back();
        }

        // load Opauth, it will load the provider strategy and redirect to the provider
        \Auth_Opauth::forge();
    }

// 	private function profile_
    public function action_callback()
    {
        // Opauth can throw all kinds of nasty bits, so be prepared
        try {
            // get the Opauth object
            $opauth = \Auth_Opauth::forge(false);

            // and process the callback
            $status = $opauth->login_or_register();

            // fetch the provider name from the opauth response so we can display a message
            $provider = $opauth->get('auth.provider', '?');

            // deal with the result of the callback process
            switch ($status) {
                // a local user was logged-in, the provider has been linked to this user
                case 'linked':
                    // inform the user the link was succesfully made
                    //\Messages::success(sprintf(__('login.provider-linked'), ucfirst($provider)));
                    // and set the redirect url for this status
// 					$uid = $opauth->get('auth.uid', '?');
// 					$profile = 
                    $url = $this->get_redirect_url();
                    break;

                // the provider was known and linked, the linked account as logged-in
                case 'logged_in':
                    // inform the user the login using the provider was succesful
                    //\Messages::success(sprintf(__('login.logged_in_using_provider'), ucfirst($provider)));
                    // and set the redirect url for this status
                    $url = $this->get_redirect_url();
                    break;

                // we don't know this provider login, ask the user to create a local account first
                case 'register':
                    // inform the user the login using the provider was succesful, but we need a local account to continue
                    //\Messages::info(sprintf(__('login.register-first'), ucfirst($provider)));
                    // and set the redirect url for this status
                    $raw = $opauth->get('auth.raw', '?');
                    $age_range_min = @$raw['age_range']['min'];
                    $age_range_max = @$raw['age_range']['max'];

                    // goro's システムでsns関連テーブルへのインサートが行われていなかったので、goro'sシステムでSNSログインをしていた人は関連テーブルへのインサートを行う
                    if (\Auth::login($opauth->get('auth.uid', '?'), $opauth->get('auth.uid', '?'))) {
                        $user_id = \Auth::get_user_id();
                        // call Opauth to link the provider login with the local user
                        $opauth->link_provider(array(
                            'parent_id' => (int)$user_id[1],
                            'provider' => $provider,
                            'uid' => $opauth->get('auth.uid'),
                            'access_token' => $opauth->get('auth.credentials.token', null),
                            'secret' => $opauth->get('auth.credentials.secret', null),
                            'expires' => $opauth->get('auth.credentials.expires', null),
                            'refresh_token' => $opauth->get('auth.credentials.refresh_token', null),
                            'created_at' => time()
                        ));

                        // ログイン
                        \Auth::instance()->force_login((int)$user_id[1]);
                        $url = $this->get_redirect_url();
                        break;
                    }

                    $userdata = [
                        'group' => 1,
                        'uid' => $opauth->get('auth.uid', '?'),
                        'provider' => $opauth->get('auth.provider', '?'),
                        'fbid' => $opauth->get('auth.uid', '?'),
                        'name' => $opauth->get('auth.info.name', '?'),
                        'first_name' => $opauth->get('auth.info.first_name', '?'),
                        'last_name' => $opauth->get('auth.info.last_name', '?'),
                        'age_range_min' => $age_range_min,
                        'age_range_max' => $age_range_max,
                        'gender' => $opauth->get('auth.info.gender', '?'),
                        'locale' => $opauth->get('auth.info.locale', '?'),
                        'timezone' => $opauth->get('auth.info.timezone', '?'),
                        'email' => $opauth->get('auth.info.email', '?'),
                        'image' => $opauth->get('auth.info.image', '?'),
//						'last_login' => \Date::time()->get_timestamp(),
//						'login_hash' => md5(time()),

                        'access_token' => $opauth->get('auth.credentials.token', null),
                        'secret' => $opauth->get('auth.credentials.secret', null),
                        'expires' => $opauth->get('auth.credentials.expires', null),
                        'refresh_token' => $opauth->get('auth.credentials.refresh_token', null),
                    ];
                    \Session::set_flash('userdata', $userdata);

                    $url = '/regist_sns';
                    break;

                // we didn't know this provider login, but enough info was returned to auto-register the user
                case 'registered':
                    // inform the user the login using the provider was succesful, and we created a local account
                    //\Messages::success(__('login.auto-registered'));
                    // and set the redirect url for this status
                    $url = $this->get_redirect_url();
                    break;

                default:
                    throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
            }
            \Response::redirect($url);
        } // deal with Opauth exceptions
        catch (\OpauthException $e) {
            echo $e->getMessage();
            exit();
            //\Messages::error($e->getMessage());
            \Response::redirect_back();
        } // catch a user cancelling the authentication attempt (some providers allow that)
        catch (\OpauthCancelException $e) {
            echo __LINE__;
            exit();
            // you should probably do something a bit more clean here...
            exit('It looks like you canceled your authorisation.' . \Html::anchor('users/oath/' . $provider, 'Click here') . ' to try again.');
        }

    }

    /**
     * ログイン・会員登録後のリダイレクト先URL取得
     * @return string
     */
    private function get_redirect_url()
    {
        if ($after_login_url = \Session::get('after_login_url')) {
            $url = $after_login_url;
        } else if ($referrer = \Session::get('referrer')) {
            $url = $referrer;
        } else {
            $url = '/my';
        }
        \Session::set('after_login_url', '');
        \Session::set('referrer', '');

        return $url;
    }
}
