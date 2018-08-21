<?php

$seeds = array(
    array('id' => '1', 'code' => '3nCQWo', 'question' => '社会人になって\n5年目以上\nそろそろ、いい大人です！', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'code' => 'ZwKusw', 'question' => '家族や友達とお金の話が\nオープンにできる関係。', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'code' => '7XEwlR', 'question' => '漠然とした未来への\nもやもや不安がある•••\n私のミライって大丈夫？', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'code' => 'A4pHeO', 'question' => 'きんゆうとか投資と\n聞くと”ん？”って思う！\nでも不安だから気になる•••', 'created_at' => \DB::expr('now()')),
    array('id' => '5', 'code' => 'Hx3wbd', 'question' => 'もう少し\n毎月の収入上げたい！\n転職とかフリーランスとか\n副業って気になる！', 'created_at' => \DB::expr('now()')),
    array('id' => '6', 'code' => 'nUNq1B', 'question' => 'ひとりでいるより\n女子会とかおともだちと\n会うのが楽しい！\nおしゃべりが好き。', 'created_at' => \DB::expr('now()')),
    array('id' => '7', 'code' => 'VgE5Mu', 'question' => '何かを始める時、友だち\nとかの後押しが無いと\n前に進めない！\nでも結構下調べする派。', 'created_at' => \DB::expr('now()')),
    array('id' => '8', 'code' => 'mTLaun', 'question' => 'よく悩みがなさそう\n幸せそうだネ★と言われる•••\nそんなつもりじゃないケド•••', 'created_at' => \DB::expr('now()')),
    array('id' => '9', 'code' => 'JkvoS5', 'question' => 'ライブイベントを想定して\nある程度お金を貯めている！\n1～3 ヶ月分くらい', 'created_at' => \DB::expr('now()')),
    array('id' => '10', 'code' => 'JXBiGW', 'question' => 'お財布がパンパン！\n美容・食事は結構お金を\nかけているかも。', 'created_at' => \DB::expr('now()')),
    array('id' => '11', 'code' => 'EuYdha', 'question' => 'TVとか雑誌よりキュレーションメディア派。\nアンテナをはって新しく\nいろんな情報を得たい！', 'created_at' => \DB::expr('now()')),
    array('id' => '12', 'code' => '7nuMaT', 'question' => '人とは違う経験や\n旅行が好き！', 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_routes')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_routes')->set($seed)->execute();
}

$seeds = array(
    array('id' => '1', 'code' => 'RgKLhu', 'type' => 'A', 'character_name' => 'そろそろきちんとやらなきゃさん', 'catch_copy' => ' \ 人生100年時代に備えたい /', 'description' => '金融？何のこと？\n自分が何がワカラナイか\nそれすらワカラナイ•••\n金融とか投資とか自分には関係ない？\nでもそろそろお金の整理からはじめたい！', 'character_image' => '/images/diagnosticchart/A.png', 'type_image' => '/images/diagnosticchart/typeA.png', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'code' => 'pttyS2', 'type' => 'B', 'character_name' => '先延ばしなまよい子さん', 'catch_copy' => '\ みんなのリアルを教えて欲しい /', 'description' => 'お金のコト大事ってわかったケド\n何したらいいかな・・・？\nみんなどうしてるの？\n怖いから迷って、いつのまにか\n時間が経ってる・・・', 'character_image' => '/images/diagnosticchart/B.png', 'type_image' => '/images/diagnosticchart/typeB.png', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'code' => 'pT8Xsz', 'type' => 'C', 'character_name' => 'ついついなんとかなる ? 子さん', 'catch_copy' => '\ 自分への投資が欠かせない /', 'description' => '貯金あんまりないです•••\nがんばって働いてはいるけど\nその分使ってる！汗\nあんまり心配してなかったけど\nこのままで大丈夫かな、ワタシ。', 'character_image' => '/images/diagnosticchart/C.png', 'type_image' => '/images/diagnosticchart/typeC.png', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'code' => 'GT7f0Q', 'type' => 'D', 'character_name' => 'わくわく冒険したい子さん', 'catch_copy' => '\ 人生もっと自由に楽しみたい！ /', 'description' => '金融に強くなって\n自分に自信をつけたい！\n仕事もプライベートも\nもっとレベル UP したい！', 'character_image' => '/images/diagnosticchart/D.png', 'type_image' => '/images/diagnosticchart/typeD.png', 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_types')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_types')->set($seed)->execute();
}

$seeds = array(
    array('id' => '1', 'route_code' => 'A4pHeO', 'type_code' => 'RgKLhu', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'route_code' => 'VgE5Mu', 'type_code' => 'pttyS2', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'route_code' => 'JXBiGW', 'type_code' => 'pT8Xsz', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'route_code' => '7nuMaT', 'type_code' => 'GT7f0Q', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '5', 'route_code' => '7nuMaT', 'type_code' => 'RgKLhu', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '6', 'route_code' => 'EuYdha', 'type_code' => 'pttyS2', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '7', 'route_code' => 'JkvoS5', 'type_code' => 'pT8Xsz', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_route_types')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_route_types')->set($seed)->execute();
}

$seeds = array(
    array('id' => '1', 'route_code' => '3nCQWo', 'next_route_code' => '7XEwlR', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'route_code' => '3nCQWo', 'next_route_code' => 'ZwKusw', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'route_code' => 'ZwKusw', 'next_route_code' => 'Hx3wbd', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'route_code' => 'ZwKusw', 'next_route_code' => 'A4pHeO', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '5', 'route_code' => '7XEwlR', 'next_route_code' => 'Hx3wbd', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '6', 'route_code' => '7XEwlR', 'next_route_code' => 'nUNq1B', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '7', 'route_code' => 'A4pHeO', 'next_route_code' => 'VgE5Mu', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '8', 'route_code' => 'Hx3wbd', 'next_route_code' => 'mTLaun', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '9', 'route_code' => 'Hx3wbd', 'next_route_code' => 'VgE5Mu', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '10', 'route_code' => 'nUNq1B', 'next_route_code' => 'mTLaun', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '11', 'route_code' => 'nUNq1B', 'next_route_code' => 'JkvoS5', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '12', 'route_code' => 'VgE5Mu', 'next_route_code' => 'JXBiGW', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '13', 'route_code' => 'mTLaun', 'next_route_code' => 'JXBiGW', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '14', 'route_code' => 'mTLaun', 'next_route_code' => 'EuYdha', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '15', 'route_code' => 'JkvoS5', 'next_route_code' => 'EuYdha', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
    array('id' => '16', 'route_code' => 'JXBiGW', 'next_route_code' => '7nuMaT', 'yes_no' => '0', 'created_at' => \DB::expr('now()')),
    array('id' => '17', 'route_code' => 'EuYdha', 'next_route_code' => '7nuMaT', 'yes_no' => '1', 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_route_paths')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_route_paths')->set($seed)->execute();
}




