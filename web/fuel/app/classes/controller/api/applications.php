<?php

use \Model\Applications;
use \Model\PaymentPayjp;
use \Model\Payment\Payjp;
use \Model\Events;
//use \Model\EventCoupons;

class Controller_Api_Applications extends Controller_Apibase
{
    public function action_delete()
    {
        if (!Auth::check()) {
            \Session::set('referrer', \Input::referrer());
            return $this->ok('login');
        }

        $code = \Input::post('code');

        $event_code = Applications::get_event_code_by_code($code);

        if (!Events::cancelable($event_code)) {
            $res = Applications::non_cancelable_cancel($code);
        } else {
            $res = Applications::cancelable_cancel($code);
        }
        if (is_string($res)) {
            return $this->error($res);
        }
        return $this->ok($res);
    }

    public function action_create()
    {
        if (!Events::applicable(\Input::post('event_code'))) {
            return $this->error('イベントの受付を終了いたしました。');
        }
        $val = Applications::validate();
        if (!$val->run(\Input::post())) {
            $error_messages = $val->error_message();
            $message = reset($error_messages);
            return $this->error($message);
        }

        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {

            // 女子会データ取得
            $event = Events::getByCode('events', $val->validated('event_code'));

            // ユーザーネーム
            $username = \Auth::get('username');

            // 申し込みデータ作成
            $application = Applications::create(
                $username,
                $val->validated('event_code'),
                $val->validated('name'),
                $val->validated('email'),
                $val->validated('coupon_code'),
                $val->validated('message')
            );

            // クレジットカード処理
            // 与信
            if ($application['amount'] > 0) {
                \Config::load('payjp', true);

                $payment = new PaymentPayjp(new Payjp(\Config::get('payjp.private_key')));

                // payjp登録ユーザー
                if (!$payment->getCustomer($username)) {
                    $customer = $payment->createCreditCustomer($username, $val->validated('name'), $val->validated('email'));
                } else {
                    $customer = $payment->updateCreditCustomer($username, $val->validated('name'), $val->validated('email'));
                }

                // 登録カードID取得（新規登録の場合は登録後にカードIDを取得）
                if ($val->validated('cardselect') === '0') {
                    $card = $payment->registNewCreditCard($customer, $val->validated('token'), $username, $val->validated('name'));
                    $cardselect = $card->id;
                } else {
                    $cardselect = $val->validated('cardselect');
                }

                // カード与信処理
                $payment->charge(
                    $customer,
                    $val->validated('name'),
                    $val->validated('email'),
                    $application['amount'],
                    $application['code'],
                    $cardselect
                );
            }

            $db->commit_transaction();

            // サンクスメール
            $mail = \Email::forge('jis');
            $mail->from("no-reply@kinyu-joshi.jp", ''); //送り元
            $mail->subject("【きんゆう女子。】女子会のお申込みありがとうございます。");
            $mail->html_body(\View::forge('email/joshikai/body',
                array(
                    'name' => $val->validated('name'),
                    'event' => $event
                )));
            $mail->to($val->validated('email')); //送り先

            $mail->return_path('support@kinyu-joshi.jp');
            $mail->send();

            return $this->ok();
        } catch(\EmailValidationFailedException $e) {
            \Log::error($e->getMessage());
            return $this->ok();
        } catch(\EmailSendingFailedException $e) {
            \Log::error($e->getMessage());
            return $this->ok();
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            $db->rollback_transaction();
            return $this->error($e->getMessage());
        }
    }

    public function action_force_delete()
    {
        if (!Auth::check()) {
            return $this->error('no administrator');
        }

        $group = Auth::group();
        if (!(in_array('admin', $group->get_roles()) || in_array('joshikai_admin', $group->get_roles()))) {
            return $this->error('no administrator');
        }

        $code = \Input::post('code');

        $event_code = Applications::get_event_code_by_code($code);

        $username = \Auth::get('username');

        if (!Events::cancelable($event_code)) {
            $res = Applications::non_cancelable_cancel($code, $username);
        } else {
            $res = Applications::cancelable_cancel($code, $username);
        }
        if (is_string($res)) {
            return $this->error($res);
        }
        return $this->ok($res);
    }
}
