<?php

namespace Fuel\Migrations;

class Create_blog_comments
{
	public function up()
	{
		\DBUtil::create_table('blog_comments', array(
			'id' => array('type' => 'bigint', 'auto_increment' => true, 'unsigned' => true),
			'blog_code' => array('constraint' => 50, 'type' => 'varchar'),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'message' => array('type' => 'text'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

        ), array('id'), true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'blog_comments_ibfk_1',
                    'key' => 'blog_code',
                    'reference' => array(
                        'table' => 'blogs',
                        'column' => 'code'
                    )
                ),
            )
        );
	}

	public function down()
	{
		\DBUtil::drop_table('blog_comments');
	}
}