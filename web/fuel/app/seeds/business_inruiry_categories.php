<?php

$seeds = array(
    array(
        'id' => '1',
        'code' => "0I9jl4",
        'sort' => '2',
        'name' => "座談会・アンケートを実施したい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '2',
        'code' => "9j8f4Y",
        'sort' => '3',
        'name' => "女子会・イベントを開催したい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '3',
        'code' => "r543Jk",
        'sort' => '4',
        'name' => "WEBサイトやLPの企画・デザイン制作をお願いしたい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '4',
        'code' => "4n8H3G",
        'sort' => '5',
        'name' => "パンフレットやノベルティグッズの企画・デザイン制作をお願いしたい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '5',
        'code' => "1jLKRf",
        'sort' => '6',
        'name' => "写真・イラスト・データなど素材を使いたい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '6',
        'code' => "5jUR89",
        'sort' => '7',
        'name' => "メルマガ配信、サンプリングなど広告を行いたい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '7',
        'code' => "9R000P",
        'sort' => '8',
        'name' => "出張女子会を開催してほしい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '8',
        'code' => "4E010P",
        'sort' => '9',
        'name' => "司会、モデレーターを派遣してほしい",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '9',
        'code' => "1G510P",
        'sort' => '9',
        'name' => "その他",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '10',
        'code' => "9IUE08",
        'sort' => '1',
        'name' => "コミュニティからのフィードバックをもらいたい",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('business_inquiry_categories')->where(array('id' => $seed['id']))->execute();
    \DB::insert('business_inquiry_categories')->set($seed)->execute();
}
