<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */


return array(
    'default' => array(
        'charset' => 'utf8',
        'connection' => array(
            'hostname' => 'db',
            'database' => 'kinyujoshi_development',
            'username' => 'root',
            'password' => 'pass',
        ),
        'profiling' => true,
    ),
    'slave' => array(
        'charset' => 'utf8',
        'connection'  => array(
            'hostname' => 'db',
            'database' => 'kinyujoshi_development',
            'username' => 'root',
            'password' => 'pass',
        ),
        'profiling' => true,
    ),
);
