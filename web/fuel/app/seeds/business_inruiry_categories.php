<?php

$seeds = array(
    array(
        'id' => '1',
        'code' => "0I9jl4",
        'sort' => '2',
        'name' => "コミュニティマーケティングを依頼したい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '2',
        'code' => "9j8f4Y",
        'sort' => '3',
        'name' => "クリエイティブ企画、制作を依頼したい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '3',
        'code' => "r543Jk",
        'sort' => '4',
        'name' => "ブランド戦略立案を依頼したい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '4',
        'code' => "4n8H3G",
        'sort' => '5',
        'name' => "その他",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('business_inquiry_categories')->where(array('id' => $seed['id']))->execute();
    \DB::insert('business_inquiry_categories')->set($seed)->execute();
}
