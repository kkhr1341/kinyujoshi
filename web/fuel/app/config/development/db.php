<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */


return array(
	'default' => array(
    'charset' => 'utf8',
		'connection'  => array(
                        'dsn'        => 'mysql:host=db;dbname=kinyujoshi_development',
                        'username'   => 'root',
                        'password'   => 'pass',
		),
		'profiling' => true,
	),
);
