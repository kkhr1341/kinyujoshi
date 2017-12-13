<?php
/**
 * The Auth Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\Login;
use \Model\Register;
use \Model\Profiles;

class Controller_Api_Auth extends Controller_Base
{
    /**
     * ログイン
     */
	public function action_login() {
        $val = Login::validate();
        if (!$val->run()) {
            $this->error('ログインに失敗しました');
        }
        $params = $val->validated();
        if (!\Auth::login($params['email'], $params['password'])) {
            $this->error('ログインに失敗しました');
        }
        $this->ok('success');
	}

    /**
     * 会員登録
     */
    public function action_register() {
        $val = Register::validate();
        if (!$val->run()) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            $this->error($message);
        }
        $db = Database_Connection::instance();
        $db->start_transaction();
        try {
            $params = $val->validated();

            $username = Str::random('alnum', 16);

            Auth::create_user(
                $username,
                $params['password'],
                $params['email']
            );
            $profile_code = Profiles::getNewCode('profiles', 6);
            $profile = [
                'code' => $profile_code,
                'username' => $username,
                'name' => $params['name'],
                'name_kana' => $params['name_kana'],
                'nickname' => $params['name'],
                'profile_image' => '',
                'email' => $params['email'],
            ];

            Profiles::create($profile);

            $db->commit_transaction();

            Auth::login($params['email'], $params['password']);

        } catch (SimpleUserUpdateException $e) {
            $db->rollback_transaction();
            Log::error('register error::'.$e->getMessage());
            $this->error('登録に失敗しました');
        }
        $this->ok('success');
    }
}
