<?php
class Log extends \Fuel\Core\Log
{
    /**
     * create the monolog instance
     */
    public static function _init()
    {
        \Config::load('cloudwatchlogs', true);

        $client = new Aws\CloudWatchLogs\CloudWatchLogsClient(\Config::get('cloudwatchlogs.client'));
        $handler = new Maxbanton\Cwh\Handler\CloudWatch(
            $client,
            \Config::get('cloudwatchlogs.group', null), // ロググループ名
            \Fuel::$env, // ログストリーム名
            \Config::get('cloudwatchlogs.retentionDays', null),
            10000
        );

        $logger = new \Monolog\Logger('cloudwatchlogs');
        $logger->pushHandler($handler);

        static::$monolog = $logger;

        static::initialize();
    }
}