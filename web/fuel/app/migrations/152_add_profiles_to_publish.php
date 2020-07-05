<?php

namespace Fuel\Migrations;

class Add_profiles_to_publish
{
  public function up()
  {
    \DBUtil::add_fields('profiles', array(
      'publish' => array('type' => 'tinyint', 'null' => false, 'default' => '0'),
    ));
  }

  public function down()
  {
    \DBUtil::drop_fields('profiles', array(
      'publish',
    ));
  }
}

