<?php
return array(
	'_root_'  => 'kinyu/top',  // The default route
	'_404_'   => '/error/404',    // The main 404 route
	'_500_'   => '/error/500',    // The main 404 route
	'my'   => 'my/top',
	'page/(:any)'   => 'page/top/$1',
	
	//◆メンバー登録/ログイン部分
	'login_regist'   => 'login/regist',
	'regist_email'   => 'login/regist_email',
	'regist_sns'   => 'login/regist_sns',

	//会員登録情報
	'my/registlist' => 'my/registlist/index',
	'my/registlist/create' => 'my/registlist/create',
	'my/registlist/(:any)'   => 'my/registlist/detail/$1',

	//マイページ
	'my/profile'   => 'my/profile/index',
	'my/joshikai' => 'my/events/joshikailist',
	'my/joshikai/(:any)' => 'my/events/joshikaidetail/$1',

	//テスト環境
	'testindex' => 'kinyu/top/testindex',
	'testsp' => 'kinyu/top/testspindex',
		
	// きんゆう女子
	'kinyu'   => 'kinyu/top',
	
	//aboutページ
	'about' => 'kinyu/about/index',
	'about_main' => 'kinyu/about/about_main',
	'about_contents' => 'kinyu/about/about_contents',
	'about_story' => 'kinyu/about/about_story',
	'about_policy' => 'kinyu/about/about_policy',
	'about_design' => 'kinyu/about/about_design',
	'about_hensyubu' => 'kinyu/about/about_hensyubu',

	'report'   => 'kinyu/blog/index',
	'report/(:num)'   => 'kinyu/blog/index/$1',
	'report/(:any)'   => 'kinyu/blog/detail/$1',
	'welcome/blog/(:any)'   => 'kinyu/blog/welcome/$1',
	'rsss'   => 'kinyu/rss/index',
	'rss/(:num)'   => 'kinyu/rss/index/$1',
	'rss/(:any)'   => 'kinyu/rss/detail/$1',

	//myplan
	'myway' => 'kinyu/myway/index',

	//未公開
	'gallery' => 'kinyu/gallery/index',
	//'event/schedule'   => 'kinyu/event/schedule',
	//'event/(:num)'   => 'kinyu/event/index/$1',
	//'event/(:any)'   => 'kinyu/event/detail/$1',
	//'welcome/event'   => 'kinyu/event/welcome',

	//イベント関連
	'joshikai'   => 'kinyu/event/index',
	'joshikai/(:any)'   => 'kinyu/event/detail/$1',
	'joshikai_tickets/(:any)'   => 'kinyu/event/tickets/$1',
	'joshikai_payment_card/(:any)'   => 'kinyu/event/tickets_card/$1',
	'joshikai_payment_cash/(:any)'   => 'kinyu/event/tickets_cash/$1',
	'joshikai_complete'   => 'kinyu/event/complete',

	//ニュース
	'news'   => 'kinyu/news/index',
	'news/1'   => 'kinyu/news/index',
	'news/(:num)'   => 'kinyu/news/index/$1',
	'news/(:any)'   => 'kinyu/news/detail/$1',
	
	//お問い合わせ
	'contact' => 'kinyu/inquiry',	
	'contact/complete' => 'kinyu/inquiry/complete',

	//会員登録
	'regist' => 'kinyu/regist',
	'regist/complete' => 'kinyu/regist/complete',

	//きんゆうのワカラナイをリクエスト
	'request' => 'kinyu/kuchikomi',
	'request/complete' => 'kinyu/kuchikomi/complete',

	// 会社概要
	'company' => 'kinyu/company/index',

	//利用規約
	'service' => 'kinyu/company/service',

	//プライバシーポリシー
	'privacy' => 'kinyu/company/privacy',

	//特定商取引法に基づく表記
	'legal' => 'kinyu/company/legal',

		//企業用ページ
	'business' => 'kinyu/company/business',

	//キャンペーン
	'school' => 'kinyu/campaign/school',
	'school_jpx' => 'kinyu/campaign/school_public',
	'conference' => 'kinyu/campaign/conference',
	'map' => 'kinyu/campaign/map',
	'oom-reit' => 'kinyu/campaign/ooedoonsen_joshikai',
	'celebration' => 'kinyu/campaign/celebration_20171206',

	'blog/page/(:any)'   => 'kinyu/blog/page/index/$1',
	'event/page/(:any)'   => 'kinyu/event/page/index/$1',
	'project'   => 'kinyu/project/index',
	'project/(:num)'   => 'kinyu/project/index/$1',
	'project/(:any)'   => 'kinyu/project/detail/$1',
	
	// admin
	'my/projects/courses/create/(:any)'   => 'my/projects/courses_create/$1',
	'my/projects/courses/edit/(:any)'   => 'my/projects/courses_edit/$1',
	'my/projects/blog/create/(:any)'   => 'my/projects/blog_create/$1',
	'my/projects/blog/edit/(:any)'   => 'my/projects/blog_edit/$1',
);
