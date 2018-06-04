<?php

$seeds = array(
    array(
        'id' => '1',
        'code' => "5E9d0E",
        'sort' => '1',
        'name' => "退会したいから",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '2',
        'code' => "9R000P",
        'sort' => '2',
        'name' => "その他",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('withdrawal_reasons')->where(array('id' => $seed['id']))->execute();
    \DB::insert('withdrawal_reasons')->set($seed)->execute();
}
