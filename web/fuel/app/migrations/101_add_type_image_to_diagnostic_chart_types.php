<?php

namespace Fuel\Migrations;

class Add_type_image_to_diagnostic_chart_types
{
	public function up()
	{
		\DBUtil::add_fields('diagnostic_chart_types', array(
			'type_image' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'character_name'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('diagnostic_chart_types', array(
			'type_image',

		));
	}
}
