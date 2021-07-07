<?php

$seeds = array(
    array('id' => '1', 'name' => 'PRアンバサダー', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'name' => '体験モニター', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'name' => 'ライター', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'name' => 'ファシリテーター', 'created_at' => \DB::expr('now()')),
    array('id' => '5', 'name' => 'ゲスト', 'created_at' => \DB::expr('now()')),
    array('id' => '6', 'name' => '企画・主催者', 'created_at' => \DB::expr('now()')),
    array('id' => '7', 'name' => 'サポーター', 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('official_member_jobs')->where(array('id' => $seed['id']))->execute();
    \DB::insert('official_member_jobs')->set($seed)->execute();
}
