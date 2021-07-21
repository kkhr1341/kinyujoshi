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
            'hostname' => 'dbsrv-sundaylunch-cluster-1.cluster-cqeoc0c4hmvu.ap-northeast-1.rds.amazonaws.com',
            'database' => 'kinyujoshi',
            'username' => 'root',
            'password' => ']8Dvung|',
        ),
        'profiling' => true,
    ),
    'slave' => array(
        'charset' => 'utf8',
        'connection'  => array(
            'hostname' => 'dbsrv-sundaylunch-cluster-1.cluster-ro-cqeoc0c4hmvu.ap-northeast-1.rds.amazonaws.com',
            'database' => 'kinyujoshi',
            'username' => 'root',
            'password' => ']8Dvung|',
        ),
        'profiling' => true,
    ),
);

