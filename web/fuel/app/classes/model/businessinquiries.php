<?php

namespace Model;
require_once(dirname(__FILE__) . "/base.php");

class BusinessInquiries extends Base
{

    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('code');

        $val->add('category_code', 'お問い合わせ種別')
            ->add_rule('required');

//        $val->add('attachment_file', 'ファイルの添付');

        $val->add('company', '会社名');

        $val->add('department', '部署名');

        $val->add('name', 'お名前');

        $val->add('tel', '電話番号');

        $val->add('email', 'メールアドレス');

        $val->add('appointment_date1', 'アポイントご希望の日時 候補日1');
        $val->add('appointment_date2', 'アポイントご希望の日時 候補日2');
        $val->add('appointment_date3', 'アポイントご希望の日時 候補日3');

        $val->add('transmission', 'きんゆう女子。を知ったきっかけ');

        $val->add('message', 'お問い合わせ内容');

        return $val;
    }

    public static function create($params, $files=array())
    {
        $data = array();

        $code = self::getNewCode('business_inquiries');

        $data['code'] = $code;
        $data['category_code'] = $params['category_code'];
        $data['company'] = $params['company'];
        $data['department'] = $params['department'];
        $data['name'] = $params['name'];
        $data['tel'] = $params['tel'];
        $data['email'] = $params['email'];
        $data['transmission'] = $params['transmission'];
        $data['message'] = $params['message'];

        $data['username'] = \Auth::get('username');
        $data['created_at'] = \DB::expr('now()');
        $params['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        \DB::insert('business_inquiries')->set($data)->execute();

        $data['appointment_date1'] = $params['appointment_date1'];
        if ($data['appointment_date1']) {
            \DB::insert('business_inquiry_appointment_dates')->set(array(
                'business_inquiry_code' => $code,
                'appointment_date' => $params['appointment_date1'],
                'created_at' => \DB::expr('now()')
            ))->execute();
        }

        $data['appointment_date2'] = $params['appointment_date2'];
        if ($data['appointment_date2']) {
            \DB::insert('business_inquiry_appointment_dates')->set(array(
                'business_inquiry_code' => $code,
                'appointment_date' => $params['appointment_date2'],
                'created_at' => \DB::expr('now()')
            ))->execute();
        }

        $data['appointment_date3'] = $params['appointment_date3'];
        if ($data['appointment_date3']) {
            \DB::insert('business_inquiry_appointment_dates')->set(array(
                'business_inquiry_code' => $code,
                'appointment_date' => $params['appointment_date3'],
                'created_at' => \DB::expr('now()')
            ))->execute();
        }

        // お問い合わせ種別
        $result = \DB::select('name')->from('business_inquiry_categories')->where('code', '=', $data['category_code'])->execute()->current();
        if (empty($result)) {
            $data['category_name'] = "";
        } else {
            $data['category_name'] = $result['name'];
        }

        $email = \Email::forge('jis');
        $email->from("service@kinyu-joshi.jp", ''); //送り元
        $email->subject("【きんゆう女子。】お問い合せありがとうございました。");
        $email->html_body(\View::forge('email/business_inquiry/body', $data));
        $email->to($params['email']); //送り先

        $email->return_path('support@kinyu-joshi.jp');
        $email->send();

        $email02 = \Email::forge('jis');
        $email02->from("no-reply@kinyu-joshi.jp", ''); //送り元
        $email02->subject("【きんゆう女子。for Business】お問合せがありました。");
        $email02->html_body(\View::forge('email/business_inquiry/return', $data));
        $email02->to('service@kinyu-joshi.jp'); //送り先
        $email02->cc('cs@kinyu-joshi.jp');

        // 添付ファイル
        foreach ($files as $key => $file) {
            $filename = 'file' . ($key + 1) . '.' . $file['extension'];
            $email02->attach($file['file'], false, null, $file['mimetype'], $filename);
        }

        $email02->return_path('support@kinyu-joshi.jp');
        $email02->send();

        return $data;
    }

}
