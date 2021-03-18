<?php

$seeds = array(
    array('id' => '1',  'code' => '3nCQWo', 'question' => "社会人になって\n5年目以上\nそろそろ、いい大人です！", 'created_at' => \DB::expr('now()')),
    array('id' => '2',  'code' => 'ZwKusw', 'question' => "家族や友達とお金の話が\nオープンにできる関係。", 'created_at' => \DB::expr('now()')),
    array('id' => '3',  'code' => '7XEwlR', 'question' => "私のミライって大丈夫？\n漠然とした未来への\nもやもや不安がある•••", 'created_at' => \DB::expr('now()')),
    array('id' => '4',  'code' => 'A4pHeO', 'question' => "きんゆうとか投資と\n聞くと”ん？”って思う！\nでも不安だから気になる•••", 'created_at' => \DB::expr('now()')),
    array('id' => '5',  'code' => 'Hx3wbd', 'question' => "もう少し\n毎月の収入上げたい！\n転職とかフリーランスとか\n副業って気になる！", 'created_at' => \DB::expr('now()')),
    array('id' => '6',  'code' => 'nUNq1B', 'question' => "ひとりでいるより\n女子会とかおともだちと\n会うのが楽しい！\nおしゃべりが好き。", 'created_at' => \DB::expr('now()')),
    array('id' => '7',  'code' => 'VgE5Mu', 'question' => "何かを始める時、友だち\nとかの後押しが無いと\n前に進めない！\nでも結構下調べする派。", 'created_at' => \DB::expr('now()')),
    array('id' => '8',  'code' => 'mTLaun', 'question' => "よく悩みがなさそう\n幸せそうだネ★と言われる•••\nそんなつもりじゃないケド•••", 'created_at' => \DB::expr('now()')),
    array('id' => '9',  'code' => 'JkvoS5', 'question' => "ライフイベントを想定して\nある程度お金を貯めている！\n1～3 ヶ月分くらい", 'created_at' => \DB::expr('now()')),
    array('id' => '10', 'code' => 'JXBiGW', 'question' => "お財布がパンパン！\n美容・食事は結構お金を\nかけているかも。", 'created_at' => \DB::expr('now()')),
    array('id' => '11', 'code' => 'EuYdha', 'question' => "TVとか雑誌よりキュレーションメディア派。\nアンテナをはって新しく\nいろんな情報を得たい！", 'created_at' => \DB::expr('now()')),
    array('id' => '12', 'code' => '7nuMaT', 'question' => "人とは違う経験や\n旅行が好き！", 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_routes')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_routes')->set($seed)->execute();
}

//キャッチコピー
//catch_copy → キャッチコピー
//description → 説明文
$seeds = array(
    array('id' => '1', 'code' => 'RgKLhu', 'type' => 'A', 'character_name' => 'そろそろきちんとやらなきゃ！さん', 'catch_copy' => '人生100年って言われたけどどうすればいいの？', 'description' => "気づいたら何もワカラナイ・・・どうしよう（涙）きんゆう？何のこと？お菓子？そもそも、何がワカラナイかそれすらワカラナイ・・・。そもそもわたしってどういう人生を送っていきたいのかな？金融とか投資とか自分には関係ない？でも、そろそろきちんとやらなきゃ？！\nそろそろきちんとやらなきゃ！さんにおすすめしたい編集部セレクトブック！\n『夢をかなえる人の手帳』", 'character_image' => '/images/diagnosticchart/A.png', 'type_image' => '/images/diagnosticchart/typeA.png', 'created_at' => \DB::expr('now()')),
    array('id' => '2', 'code' => 'pttyS2', 'type' => 'B', 'character_name' => 'さきのばし…な、まよい子さん', 'catch_copy' => 'みんなのリアル、教えてほしい！', 'description' => "お金のこと大事ってわかったケド、何からはじめればいいのかな？みんなはどうしてるの？まだ、これからのこと迷っているからもう少し先でもいいかな。あれ、いつのまにか時間がたってる・・・。ふぅ。行動するのって大変だなぁ・・・。とりあえず、貯金は多少ある。\nさきのばし・・・な迷い子さんにおすすめしたい編集部セレクトブック！\n『TQ-心の安らぎを得る究極のタイムマネジメント』", 'character_image' => '/images/diagnosticchart/B.png', 'type_image' => '/images/diagnosticchart/typeB.png', 'created_at' => \DB::expr('now()')),
    array('id' => '3', 'code' => 'pT8Xsz', 'type' => 'C', 'character_name' => 'ついついなんとかなる？子さん', 'catch_copy' => '自分への投資が欠かせない！『どうにかなるよね！！？（・・・なってない）』', 'description' => "実は、お金の管理、苦手。貯金あんまりないです・・・。もっとお金を作りたい！欲しいものたくさんあるし、がんばって働いてはいるけど、ついつい使ってしまう。汗あんまり考えてこなかったけど、このままで大丈夫かな？！ワタシ。\nついついなんとかなる子？さんにおすすめしたい編集部セレクトブック！\n『「幸せをお金で買う」5つの授業 ―HAPPY MONEY』", 'character_image' => '/images/diagnosticchart/C.png', 'type_image' => '/images/diagnosticchart/typeC.png', 'created_at' => \DB::expr('now()')),
    array('id' => '4', 'code' => 'GT7f0Q', 'type' => 'D', 'character_name' => 'わくわく冒険したい子さん', 'catch_copy' => '人生もっと自由に楽しみたい！『夢は大きく！私、もっともっと幸せになる！』', 'description' => "金融に強くなって自分にもっと自信をつけたい！もちろん、迷ったり失敗したりすることはあるけれど、人生の自分の軸は見えてきた。だから、仕事もプライベートも、もっとレベルUPさせたいな。せっかくの1回の人生だから、思い切り楽しまなくちゃ♪\nわくわく冒険したい子さんにおすすめしたい編集部セレクトブック！\n『自分で「始めた」女たち 「好き」を仕事にするための最良のアドバイス&インスピレーション』", 'character_image' => '/images/diagnosticchart/D.png', 'type_image' => '/images/diagnosticchart/typeD.png', 'created_at' => \DB::expr('now()')),
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

//#タグ
$seeds = array(


    //A
    #ワカラナイ、でも大丈夫
    #お金に向き合う宣言しよう
    #ワカラナイまま生きるのは卒業
    #お金を意識しよう
    array('id' => '1',  'type_code' => 'RgKLhu', 'hash_tag' => "#ワカラナイ、でも大丈夫", 'created_at' => \DB::expr('now()')),
    array('id' => '2',  'type_code' => 'RgKLhu', 'hash_tag' => "#お金に向き合う宣言しよう", 'created_at' => \DB::expr('now()')),
    array('id' => '3',  'type_code' => 'RgKLhu', 'hash_tag' => "#ワカラナイまま生きるのは卒業", 'created_at' => \DB::expr('now()')),
    array('id' => '4',  'type_code' => 'RgKLhu', 'hash_tag' => "#お金を意識しよう", 'created_at' => \DB::expr('now()')),

    //B
    #意志はあるんです
    #今できることをやろう
    #みんなと一緒にチャレンジ
    #迷うのもいいこと
    array('id' => '5',  'type_code' => 'pttyS2', 'hash_tag' => "#意志はあるんです", 'created_at' => \DB::expr('now()')),
    array('id' => '6',  'type_code' => 'pttyS2', 'hash_tag' => "#今できることをやろう", 'created_at' => \DB::expr('now()')),
    array('id' => '7',  'type_code' => 'pttyS2', 'hash_tag' => "#みんなと一緒にチャレンジ", 'created_at' => \DB::expr('now()')),
    array('id' => '8',  'type_code' => 'pttyS2', 'hash_tag' => "#迷うのもいいこと", 'created_at' => \DB::expr('now()')),

    //C
    #仕事大好き
    #新しいものも好き
    #いろんなこと興味がある
    #バイタリティがあるってこと
    array('id' => '9',  'type_code' => 'pT8Xsz', 'hash_tag' => "#仕事大好き", 'created_at' => \DB::expr('now()')),
    array('id' => '10', 'type_code' => 'pT8Xsz', 'hash_tag' => "#新しいものも好き", 'created_at' => \DB::expr('now()')),
    array('id' => '11', 'type_code' => 'pT8Xsz', 'hash_tag' => "#いろんなこと興味がある", 'created_at' => \DB::expr('now()')),
    array('id' => '12', 'type_code' => 'pT8Xsz', 'hash_tag' => "#バイタリティがあるってこと", 'created_at' => \DB::expr('now()')),

    //D
    #もっと自由になりたい
    #いつもワクワクしたい
    #ある程度自信がついた
    #磨きをかけよう
    array('id' => '13', 'type_code' => 'GT7f0Q', 'hash_tag' => "#もっと自由になりたい", 'created_at' => \DB::expr('now()')),
    array('id' => '14', 'type_code' => 'GT7f0Q', 'hash_tag' => "#いつもワクワクしたい", 'created_at' => \DB::expr('now()')),
    array('id' => '15', 'type_code' => 'GT7f0Q', 'hash_tag' => "#ある程度自信がついた", 'created_at' => \DB::expr('now()')),
    array('id' => '16', 'type_code' => 'GT7f0Q', 'hash_tag' => "#磨きをかけよう", 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_type_hash_tags')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_type_hash_tags')->set($seed)->execute();
}

//アクション
$seeds = array(
    //A
    array('id' => '1', 'type_code' => 'RgKLhu', 'content' => "1.お金について考えてみる！と誰かに宣言してみよう\n2.おしゃべり女子会にお友達とゆるりと参加してみよう\n3.きん女。のゲストやFPとお財布を整理整頓しよう♪", 'created_at' => \DB::expr('now()')),

    //B
    array('id' => '2', 'type_code' => 'pttyS2', 'content' => "1.みんなどうしているかレポートを読んでみよう\n2.finbeeやZaimをつかってお金のこと誰かとシェアしよう\n3.アクションする女子会でみんなと一緒に前に進もう", 'created_at' => \DB::expr('now()')),

    //C
    array('id' => '3', 'type_code' => 'pT8Xsz', 'content' => "1.時間やお金の使い道の優先度を考えよう。\n2.前払い式決済(チャージ式)の交通系電子マネー・QRコード決済や、すぐ引き落としされるデビットカードを使って、今あるお金でやりくりしよう。\n3.貯まっているポイントでつみたて運用を始めてみる？", 'created_at' => \DB::expr('now()')),

    //D
    array('id' => '4', 'type_code' => 'GT7f0Q', 'content' => "1.ニュースやアナリストの話に慣れるよう、きんゆう単語を学ぼう！\n2.つみたてNISAやNISAで、本当の投資にチャレンジ！\n3.発信することで得られる学びも。これまで実践してきたことを、自分で発信してみよう！", 'created_at' => \DB::expr('now()')),
);

foreach ($seeds as $key => $seed) {
    \DB::delete('diagnostic_chart_type_action_lists')->where(array('id' => $seed['id']))->execute();
    \DB::insert('diagnostic_chart_type_action_lists')->set($seed)->execute();
}
