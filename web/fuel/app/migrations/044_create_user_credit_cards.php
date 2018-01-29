<?php

namespace Fuel\Migrations;

class Create_user_credit_cards
{
	public function up()
	{
		\DBUtil::create_table('user_credit_cards', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'card_id' => array('constraint' => 255, 'type' => 'varchar'),

            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'timestamp'),

		), array('id'), true, 'InnoDB', null);
	}

	public function down()
	{
		\DBUtil::drop_table('user_credit_cards');
	}
}