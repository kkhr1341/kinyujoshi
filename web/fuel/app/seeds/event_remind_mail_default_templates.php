<?php

$seeds = array(
    array(
        'id' => '1',
        'subject' => "お世話になっております。",
        'body' => "こんにちは\nテストメール\nよろしくおねがいたします。",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('event_remind_mail_default_templates')->where(array('id' => $seed['id']))->execute();
    \DB::insert('event_remind_mail_default_templates')->set($seed)->execute();
}
