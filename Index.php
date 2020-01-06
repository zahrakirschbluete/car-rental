<?php
use Carrental\Core\Config;
use Carrental\Core\Router;
use Carrental\Core\Request;
use Carrental\Utils\DependencyInjector;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// added these three lines so that I can use Twig
require_once __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$view = new Twig_Environment($loader);

$config = new Config();
$dbConfig = $config->get('database');

$db = new PDO(
    'mysql:host=' . $dbConfig['host'] .
    ';dbname=' . $dbConfig['database'],
    $dbConfig['user'],
    $dbConfig['password']
);



$log = new Logger('carrental');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
$di->set('Logger', $log);

echo "<!DOCTYPE html>";
$router = new Router($di);
$response = $router->route(new Request());
echo $response;
