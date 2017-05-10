<?php
return array(
	'_root_'  => 'kinyu/top',  // The default route
	'_404_'   => '/error/404',    // The main 404 route
	'_500_'   => '/error/500',    // The main 404 route
	'my'   => 'my/top',
	'page/(:any)'   => 'page/top/$1',
	'blogs'   => 'blogs/top',

	//admin

	//会員登録情報
	'my/registlist' => 'my/registlist/index',
	'my/registlist/(:any)'   => 'my/registlist/detail/$1',

	//テスト環境
	'testindex' => 'kinyu/top/testindex',
	'testsp' => 'kinyu/top/testspindex',
		
	// きんゆう女子
	'kinyu'   => 'kinyu/top',
	'about' => 'kinyu/about/index',
	'report'   => 'kinyu/blog/index',
	'report/1'   => 'kinyu/top',
	'report/(:num)'   => 'kinyu/blog/index/$1',
	'report/(:any)'   => 'kinyu/blog/detail/$1',
	'welcome/blog/(:any)'   => 'kinyu/blog/welcome/$1',
	'rsss'   => 'kinyu/rss/index',
	'rss/(:num)'   => 'kinyu/rss/index/$1',
	'rss/(:any)'   => 'kinyu/rss/detail/$1',

	//未公開
	//'myplan' => 'kinyu/about/myplan',
	'gallery' => 'kinyu/gallery/index',
	//'event/schedule'   => 'kinyu/event/schedule',
	//'event/(:num)'   => 'kinyu/event/index/$1',
	//'event/(:any)'   => 'kinyu/event/detail/$1',
	//'welcome/event'   => 'kinyu/event/welcome',

	//イベント関連
	'event'   => 'kinyu/event/index',

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

	//キャンペーン
	'school' => 'kinyu/campaign/school',
	'school_jpx' => 'kinyu/campaign/school_public',
	'conference' => 'kinyu/campaign/conference',


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
