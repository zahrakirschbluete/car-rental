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


$header = <<<_END
<!DOCTYPE html>
<head>
<link rel='stylesheet' id='google-fonts-css'  href='https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&#038;subset=latin-ext' type='text/css' media='all' />
<link href="/css/main.css" type="text/css" rel="stylesheet" />
 <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
</head>
_END;

echo $header;
$router = new Router($di);
$response = $router->route(new Request());
echo $response;
