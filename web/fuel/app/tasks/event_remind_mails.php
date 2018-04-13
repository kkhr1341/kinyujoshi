<?php

namespace Fuel\Tasks;

class Event_remind_mails {
	
	public static function run() {

		$sql = 'select
                    *
                  from
                    events
                  where
                    event_date > now()
                    and disable = 0
                    and status = 1
                    and DATE_FORMAT(now(), "%Y-%m-%d") = DATE_FORMAT(event_date, "%Y-%m-%d") - INTERVAL 1 DAY';

		$events = \DB::query($sql)->execute();
		foreach($events as $event) {

            $sql = 'select
                        applications.code,
                        ifnull(users.email, applications.email) as email
                      from
                        applications
                        left join users on users.username = applications.username
                      where
                        disable = 0
                        and cancel = 0
                        and not exists(
                          select
                              *
                            from
                              event_remind_mails
                            where
                              event_remind_mails.application_code = applications.code
                        )
                        and event_code = "' . $event['code'] .'"';

            $applications = \DB::query($sql)->execute();
            foreach($applications as $application) {
                \DB::insert('event_remind_mails')->set(array(
                    'application_code' => $application['code'],
                    'email' => $application['email'],
                    'created_at' => \DB::expr('now()'),
                ))->execute();
            }
		}
	}
}

/* End of file tasks/robots.php */
