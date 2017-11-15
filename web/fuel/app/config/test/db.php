<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
	'default' => array(
        'connection'  => array(
            'dsn'        => 'mysql:host=test-db;dbname=kinyujoshi_test',
            'username'   => 'root',
            'password'   => 'pass',
            'port'       => '3307',
		),
		'charset' => 'utf8',
		'profiling' => true,
	),
);
