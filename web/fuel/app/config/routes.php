<?php
return array(
	'_root_'  => 'kinyu/top',  // The default route
	'_404_'   => '/error/404',    // The main 404 route
	'_500_'   => '/error/500',    // The main 404 route
	'my'   => 'my/top',
	'news'   => 'news/top',
	'page/(:any)'   => 'page/top/$1',
	'news/(:any)'   => 'news/detail/index/$1',
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
	'myplan' => 'kinyu/about/myplan',
	'gallery' => 'kinyu/gallery/index',
	'report'   => 'kinyu/blog/index',
	'report/1'   => 'kinyu/top',
	'report/(:num)'   => 'kinyu/blog/index/$1',
	'report/(:any)'   => 'kinyu/blog/detail/$1',
	'welcome/blog/(:any)'   => 'kinyu/blog/welcome/$1',
	'rsss'   => 'kinyu/rss/index',
	'rss/(:num)'   => 'kinyu/rss/index/$1',
	'rss/(:any)'   => 'kinyu/rss/detail/$1',
	//きんゆう女子・カテゴリー
	'category/investment'   => 'kinyu/investment/index',
	'category/investment/(:num)'   => 'kinyu/investment/index/$1',
	'category/special'   => 'kinyu/special/index',
	'category/special/(:num)'   => 'kinyu/special/index/$1',
	'category/money'   => 'kinyu/money/index',
	'category/money/(:num)'   => 'kinyu/money/index/$1',
	'category/lifestyle'   => 'kinyu/lifestyle/index',
	'category/lifestyle/(:num)'   => 'kinyu/lifestyle/index/$1',
	'category/fintech'   => 'kinyu/fintech/index',
	'category/fintech/(:num)'   => 'kinyu/fintech/index/$1',
	'category/business'   => 'kinyu/business/index',
	'category/business/(:num)'   => 'kinyu/business/index/$1',

	//イベント関連
	'welcome/event'   => 'kinyu/event/welcome',
	'event'   => 'kinyu/event/index',
	'event/schedule'   => 'kinyu/event/schedule',
	'event/(:num)'   => 'kinyu/event/index/$1',
	'event/(:any)'   => 'kinyu/event/detail/$1',

	//ニュース
	'news'   => 'kinyu/news/index',
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
