<?php

namespace Fuel\Tasks;

use \Model\RegistReminder;

class Regist_mails
{

    public static function send_nomembers()
    {

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

        $member_regists = \DB::query($sql)->execute();
        foreach ($member_regists as $data) {

            $email = $data['email'];
            $email = trim($email);
            $email = preg_replace("/( |　)/", "", $email);
            $regist_reminder = \DB::select('*')
                ->from('regist_reminders')
                ->where('email', '=', $email)
                ->execute()
                ->current();
            if ($regist_reminder) {
                continue;
            }

            if (!preg_match('/(.+)@(.+)/', $email)) {
                continue;
            }
            echo $data['id'] . ":";
            echo $email . "\n";
            RegistReminder::send($data['id'], $email);
        }
    }

    public static function resend_nomembers()
    {

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
                          users.username = member_regist.username
                    )';

        $member_regists = \DB::query($sql)->execute();
        foreach ($member_regists as $data) {

            $email = $data['email'];
            $email = trim($email);

            if (!preg_match('/(.+)@(.+)/', $email)) {
                continue;
            }
            echo $data['id'] . ":";
            echo $email . "\n";
            RegistReminder::send($data['id'], $email);
        }
    }

    public static function send_member($member_regist_id)
    {

        $member_regist = \DB::select('*')
            ->from('member_regist')
            ->where('id', '=', $member_regist_id)
            ->where(\DB::expr('not exists(select "x" from users where users.email = member_regist.email)'))
            ->execute()
            ->current();

        echo $member_regist['email'] . "\n";
        RegistReminder::send($member_regist['id'], $member_regist['email']);
    }
}

/* End of file tasks/robots.php */
