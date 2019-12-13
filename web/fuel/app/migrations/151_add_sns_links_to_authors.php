<?php

namespace Fuel\Migrations;

class Add_sns_links_to_authors
{
  public function up()
  {
    \DBUtil::add_fields('authors', array(
      'website' => array('type' => 'text', 'null' => true, 'after' => 'introduction'),
      'instagram' => array('type' => 'text', 'null' => true, 'after' => 'website'),
      'twitter' => array('type' => 'text', 'null' => true, 'after' => 'instagram'),
      'facebook' => array('type' => 'text', 'null' => true, 'after' => 'twitter'),
    ));
  }

  public function down()
  {
    \DBUtil::drop_fields('authors', array(
      'website',
      'instagram',
      'twitter',
      'facebook',
    ));
  }
}

