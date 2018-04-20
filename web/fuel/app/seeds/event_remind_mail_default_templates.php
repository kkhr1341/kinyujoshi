<?php

$seeds = array(
    array(
        'id' => '1',
        'subject' => "お世話になっております。",
        'body' => "{% name %}さん\n
\n
こんにちは！\n
きんゆう女子。の金子です。\n
\n
この度は、「{% event_title %}」に\n
お申込みいただきありがとうございます！\n
\n
明日はどうぞよろしくお願いいたします。\n
念のため明日のご案内です♪\n
\n
【日時】\n
{% event_date %}\n
\n
【場所】\n
{% event_place %}\n
\n
{% event_address %}\n
　  \n
【持ち物】\n
・筆記用具\n
\n
ご不明点がありましたら、遠慮なくお問い合わせくださいませ。\n
どうぞ、よろしくお願いいたします。",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('event_remind_mail_default_templates')->where(array('id' => $seed['id']))->execute();
    \DB::insert('event_remind_mail_default_templates')->set($seed)->execute();
}
