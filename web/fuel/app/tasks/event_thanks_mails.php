<?php

namespace Fuel\Tasks;

use \Model\EventThanksMailTemplates;

class Event_thanks_mails {
	
	public static function run() {

		$sql = 'select
                    events.*
                  from
                    events
                    inner join event_thanks_mail_templates on event_thanks_mail_templates.event_code = events.code
                  where
                    events.disable = 0
                    and events.status = 1
                    and event_thanks_mail_templates.status = 1
                    and DATE_FORMAT(now(), "%Y-%m-%d") = DATE_FORMAT(events.event_date, "%Y-%m-%d") + INTERVAL 1 DAY';

		$events = \DB::query($sql)->execute();
		foreach($events as $event) {

            $sql = 'select
                        applications.code,
                        applications.event_code,
                        ifnull(users.email, applications.email) as email,
                        applications.name as name
                      from
                        applications
                        left join users on users.username = applications.username
                      where
                        applications.disable = 0
                        and not exists(select "x" from application_cancels where applications.code = application_cancels.application_code)
                        and not exists(
                          select
                              *
                            from
                              event_thanks_mails
                            where
                              event_thanks_mails.application_code = applications.code
                        )
                        and applications.event_code = "' . $event['code'] .'"';

            $applications = \DB::query($sql)->execute();

            foreach($applications as $application) {
                \DB::insert('event_thanks_mails')->set(array(
                    'application_code' => $application['code'],
                    'email' => $application['email'],
                    'created_at' => \DB::expr('now()'),
                ))->execute();

                EventThanksMailTemplates::send($application['email'], $application['name'], $application['event_code']);
            }

            // no-reply?????????1?????????
            EventThanksMailTemplates::send("cs@kinyu-joshi.jp", "??????????????????????????????", $event['code']);
		}
	}
}

/* End of file tasks/robots.php */
