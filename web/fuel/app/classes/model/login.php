<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class Login extends Base {


    public static function validate()
    {
        $val = \Validation::forge();

        $val->add('email', 'メールアドレス')
            ->add_rule('required');

        $val->add('password', 'パスワード')
            ->add_rule('required');

        return $val;
    }


}