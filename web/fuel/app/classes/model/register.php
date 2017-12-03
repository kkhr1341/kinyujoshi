<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Register extends Base {


    public static function validate()
    {
        $val = \Validation::forge();
        $val->add_callable('myvalidation');

        $val->add('name', 'お名前')
            ->add_rule('required');

        $val->add('name_kana', 'ふりがな')
            ->add_rule('required');

        $val->add('birthday', '生年月日')
            ->add_rule('mb_convert_kana', 'a', 'utf-8')
            ->add_rule('valid_date');

        $val->add('email', 'メールアドレス')
            ->add_rule('required');

        $val->add('password', 'パスワード')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 255)
            ->add_rule('alphanum');

        $val->add('confirm_password', 'パスワード（確認用）')
            ->add_rule('trim')
            ->add_rule('match_validated_field', 'password')
            ->set_error_message('match_validated_field', 'パスワード（確認用）は、パスワードと異なっています');

        return $val;
    }


}