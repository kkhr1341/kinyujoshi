<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use MyApp\Chat;
use MyApp\MySessionProvider;
use MyApp\PhpSerializeHandler;

define('DB_HOST',       getenv('DB_HOST'));
define('DB_NAME',       getenv('DB_NAME'));
define('DB_USER',       getenv('DB_USER'));
define('DB_PASSWORD',   getenv('DB_PASSWORD'));
define('COOKIE_DOMAIN', getenv('COOKIE_DOMAIN'));

require_once 'vendor/autoload.php';

ini_set('session.serialize_handler', 'php_binary');
ini_set('session.cookie_domain',COOKIE_DOMAIN);
ini_set('session.name', 'fueldid');

$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbOptions = array(
    'db_table' => 'sessions',
    'db_id_col' => 'session_id',
    'db_data_col' => 'payload',
    'db_lifetime_col' => 'updated',
    'db_time_col' => 'created',
    'db_username' => DB_USER,
    'db_password' => DB_PASSWORD,
);

$server = IoServer::factory(
    new HttpServer(
        new MySessionProvider(
            new WsServer(
                new Chat()
            ),
            new PdoSessionHandler($pdo, $dbOptions),
            array(),
            new PhpSerializeHandler()
        )
    ),
    80
);

$server->run();