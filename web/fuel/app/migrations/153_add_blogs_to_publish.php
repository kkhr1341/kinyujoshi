<?php

namespace Fuel\Migrations;

class Add_blogs_to_publish
{
  public function up()
  {
    \DBUtil::add_fields('blogs', array(
      'publish' => array('type' => 'tinyint', 'null' => false, 'default' => '0', 'after' => 'secret'),
    ));
  }

  public function down()
  {
    \DBUtil::drop_fields('blogs', array(
      'publish',
    ));
  }
}

