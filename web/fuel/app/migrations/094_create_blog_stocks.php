<?php

namespace Fuel\Migrations;

class Create_blog_stocks
{
    public function up()
    {
        \DBUtil::create_table('blog_stocks', array(
            'blog_code' => array('constraint' => 50, 'type' => 'varchar'),
            'username' => array('constraint' => 50, 'type' => 'varchar'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),
        ), null, true, 'InnoDB', null,
            array(
                array(
                    'constraint' => 'blog_stocks_ibfk_1',
                    'key' => 'blog_code',
                    'reference' => array(
                        'table' => 'blogs',
                        'column' => 'code'
                    )
                ),
                array(
                    'constraint' => 'blog_stocks_ibfk_2',
                    'key' => 'username',
                    'reference' => array(
                        'table' => 'users',
                        'column' => 'username'
                    )
                ),
            )
        );
        \DBUtil::create_index('blog_stocks', array('blog_code', 'username'), 'blog_stocks_ibuk_1', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('blog_stocks');
    }
}
