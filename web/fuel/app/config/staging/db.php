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
                        'dsn'        => 'mysql:host=dbsrv-sundaylunch-cluster-1.cluster-cqeoc0c4hmvu.ap-northeast-1.rds.amazonaws.com;dbname=dev_kinyujoshi',
                        'username'   => 'root',
                        'password'   => ']8Dvung|',
		),
		'profiling' => true,
	),
);
