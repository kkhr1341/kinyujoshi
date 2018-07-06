<?php

$seeds = array(
    array(
        'id' => '1',
        'code' => "0I9jl4",
        'sort' => '1',
        'name' => "おたより(メールマガジン)が不要になりました。",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '2',
        'code' => "9j8f4Y",
        'sort' => '2',
        'name' => "きんゆう女子。の内容が私には合わなかったかな。",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '3',
        'code' => "r543Jk",
        'sort' => '3',
        'name' => "金融わかる女子になったので卒業します！",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '4',
        'code' => "4n8H3G",
        'sort' => '4',
        'name' => "女子会になかなか行かれないので。。。",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '5',
        'code' => "1jLKRf",
        'sort' => '5',
        'name' => "上手く活用できなかったので",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '6',
        'code' => "5jUR89",
        'sort' => '6',
        'name' => "登録した記憶がないため",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '7',
        'code' => "9R000P",
        'sort' => '7',
        'name' => "その他",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('withdrawal_reasons')->where(array('id' => $seed['id']))->execute();
    \DB::insert('withdrawal_reasons')->set($seed)->execute();
}
