<?php

namespace Fuel\Migrations;

class Create_views_blog_views
{
	public function up()
	{
        \DB::query('
        CREATE VIEW views_blog_views(`blog_code`, `views` ) AS
            select REPLACE(page_path, "/report/", "") as blog_code, sum(pageviews) as views from page_views where page_path REGEXP \'^\/report\/[a-zA-Z0-9]{6}$\' group by page_path
		')
            ->execute();
	}

	public function down()
	{
		\DBUtil::drop_table('views_blog_views');
	}
}