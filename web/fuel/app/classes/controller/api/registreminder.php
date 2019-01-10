<?php
/**
 * The User Api Controller.
 *
 * @package  app
 * @extends  Controller
 */

use \Model\RegistReminder;
use \Model\Regist;

class Controller_Api_Registreminder extends Controller_Apibase
{

    public function action_create()
    {
        // トークンチェック
        if (!$reminder = RegistReminder::get_valid(\Input::post('access_token'))) {
            return $this->error("トークンが不正です。");
        }

        $val = RegistReminder::validate();
        if (!$val->run()) {
            return $this->error(array_values($val->error_message()));
        } else {
            try {

                // TokenとメールアドレスをDBに登録
                return $this->ok(RegistReminder::regist($reminder['member_regist_id'], $val->validated('password')));

            } catch (\Exception $e) {
                echo $e;
                return $this->error(array('設定に失敗しました。'));
            }
        }
    }

    public function action_send()
    {
        parent::before();

        if (!Auth::has_access('registreminder.send')) {
            return $this->error('permission denied');
        }

        if (!\Input::post('code')) {
            return $this->error('invalid parameter');
        }


        if (Regist::has_account(\Input::post('code'))) {
            return $this->error('already has account');
        }

        try {
            $member_regist = \DB::select('*')
                ->from('member_regist')
                ->where('code', '=', \Input::post('code'))
                ->where(\DB::expr('not exists(select "x" from users where users.email = member_regist.email)'))
                ->execute()
                ->current();

            RegistReminder::send($member_regist['id'], $member_regist['email']);

            return $this->ok();
        } catch (\Exception $e) {
            \Log::error('regist reminder error::' . $e->getMessage());
            throw $e;
        }
    }
}
