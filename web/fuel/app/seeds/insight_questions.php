<?php

$seeds = array(
    array(
        'id' => '1',
        'name' => "感情指数",
        'expires' => "1",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('insight_questions')->where(array('id' => $seed['id']))->execute();
    \DB::insert('insight_questions')->set($seed)->execute();
}

$seeds = array(
    array(
        'id' => '1',
        'insight_question_id' => '1',
        'sort' => '1',
        'name' => "喜び",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '2',
        'insight_question_id' => '1',
        'sort' => '2',
        'name' => "普通",
        'created_at' => \DB::expr('now()'),
    ),
    array(
        'id' => '3',
        'insight_question_id' => '1',
        'sort' => '3',
        'name' => "怒り",
        'created_at' => \DB::expr('now()'),
    ),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('insight_question_labels')->where(array('id' => $seed['id']))->execute();
    \DB::insert('insight_question_labels')->set($seed)->execute();
}