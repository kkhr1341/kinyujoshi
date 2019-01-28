<?php

namespace Fuel\Migrations;

class Create_views_page_views
{
	public function up()
	{
        \DB::query('
        CREATE VIEW views_page_views(`page_path`, `views` ) AS
            select page_path, sum(pageviews) as views from page_views where page_path REGEXP \'^\/report\/[a-zA-Z0-9]{6}$\' group by page_path
		')
            ->execute();
	}

	public function down()
	{
		\DBUtil::drop_table('views_page_views');
	}
}