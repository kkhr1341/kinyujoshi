<?php

class Model_Mybbs extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'name',
        'message',
        'image',
        'ip',
        'created_at',
        'updated_at',
        'created_at',
        'updated_at',
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    protected static $_table_name = 'mybbs';

}
