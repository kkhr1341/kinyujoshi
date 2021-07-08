<?php

return array(
    'default' => array(
        'type'             => 'mysqli',
        'connection'     => array(
            'port'             => '3306',
            'persistent'     => false,
            'compress'         => false,
        ),
        'identifier'     => '`',
        'table_prefix'     => '',
        'charset'         => 'utf8',
        'enable_cache'     => true,
        'profiling'      => false,
        'readonly'       => array('slave'),
    ),
    'slave' => array(
        'type'             => 'mysqli',
        'connection'     => array(
            'port'             => '3306',
            'persistent'     => false,
            'compress'         => false,
        ),
        'identifier'     => '`',
        'table_prefix'     => '',
        'charset'         => 'utf8',
        'enable_cache'     => true,
        'profiling'      => false,
        'readonly'       => false,
    ),
);
