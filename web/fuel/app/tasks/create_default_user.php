<?php
namespace Fuel\Tasks;

class Create_default_user {
    public static function run() {
        echo "Create default user" . "\n";

        $db = \Database_Connection::instance();
        $db->start_transaction();
        try {
            $username = 'anewuser';

            $result = \DB::select()
                ->from('users')
                ->where('username', '=', $username)
                ->execute()
                ->current();

            if ($result) {
                die("Already exists user.");
            }

            \Auth::create_user(
                $username,
                '1234',
                'user@kinyu-joshi.jp',
                100
            );

            \DB::insert('profiles')
                ->set(array(
                    'code' => 100,
                    'name' => 'A. New User',
                    'name_kana' => 'A. New User',
                    'username' => $username,
                    'nickname' => 'A. New User',
                    'birthday' => '1984-09-29',
                    'prefecture' => '1MQjDx',
                    'profile_image' => '',
                    'introduction' => '自己紹介',
                    'disable' => 0,
                    'created_at' => '2019-04-19 16:35:41',
                    'updated_at' => '2019-04-19 16:35:41',
                ))
                ->execute();

            $db->commit_transaction();
        } catch (\Exception $e) {
            $db->rollback_transaction();
            throw $e;
        }
        echo "Created success!\n";
    }
}

