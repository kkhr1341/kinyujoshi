<?php

namespace Fuel\Tasks;
use \Model\RegistReminder;

class Regist_mails {
	
	public static function run() {

		$sql = 'SELECT
                    member_regist.id,
                    member_regist.email
                  FROM
                    member_regist
                    INNER JOIN (
                      SELECT
                          MAX(id) as member_regist_id
                        FROM
                          member_regist
                        WHERE
                          email <> ""
                        GROUP BY email
                    ) AS last_member_regist
                      ON last_member_regist.member_regist_id = member_regist.id
                  WHERE
                    NOT EXISTS(
                      SELECT
                          "x"
                        FROM
                          users
                        WHERE
                          users.email = member_regist.email
                    )
                    AND NOT EXISTS(
                      SELECT
                          "x"
                        FROM
                          regist_reminders
                        WHERE
                          regist_reminders.email = member_regist.email
                    )';

                $blacks = array(
                    '0bu79t1c38C3r7n@ezweb.ne.jp',
                    'jazzdream.net@me.com ',
                    'nami.a.s.73@ezweb.ne.jp',
                    'nami.a.s.73@gmail.com ',
                    'wiptdgm@gmail.com',
                    ' wiptdgm@gmail.com',
                );

		$member_regists = \DB::query($sql)->execute();
		foreach($member_regists as $data) {
                    $email = $data['email'];
                    $email = trim($email);
                    $email = preg_replace("/( |　)/", "", $email);
                    if (in_array($email, $blacks)) {
                        continue;
                    }
                    $regist_reminder = \DB::select('*')
                        ->from('regist_reminders')
                        ->where('email', '=', $email)
                        ->execute()
                        ->current();
                    if ($regist_reminder) {
                        continue;
                    } 

                    if(preg_match('/(.+)@(.+)/',$email)) {
		        echo $data['id'] . ":";
		        echo $email . "\n";
		        // RegistReminder::send($data['id'], $email);
                    }
		}
	}

	public static function test($member_regist_id) {

            $member_regist = \DB::select('*')
                ->from('member_regist')
                ->where('id', '=', $member_regist_id)
                ->execute()
                ->current();

	    echo $member_regist['email'] . "\n";
            RegistReminder::send($member_regist['id'], $member_regist['email']);
	}
}

/* End of file tasks/robots.php */
