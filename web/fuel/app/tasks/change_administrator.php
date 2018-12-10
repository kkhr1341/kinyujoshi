<?php
namespace Fuel\Tasks;

class Change_administrator {
    public static function run($model_name=null) {
        echo "Please input change user email: " . "\n";
        $email = trim(fgets(STDIN));

        $user = \DB::select('*')
            ->from('users')
            ->where('email', '=', $email)
            ->execute()
            ->current();
        if(!$user) {
            die("User not found!\n");
        }

        \DB::update('users')
            ->set(array(
                'group' => 100,
            ))
            ->where(array(
                'email' => $email,
            ))
            ->execute();

        echo "Updated success!\n";
    }
}

