<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

if (false === class_exists(Dotenv::class)) {
    throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
}

$dotenv = new Dotenv(false);

// load all the .env files
if (false === method_exists($dotenv, 'loadEnv')) {
    throw new RuntimeException('Please upgrade "symfony/dotenv" component to "4.2" or higher version.');
}

$dotenv->loadEnv(dirname(__DIR__) . '/.env');

$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = ($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? null) ?: 'dev';

//$resource = new \Rmr\Resource\Client\ClientCollectionResource();
//$resource->addOperation(new \Rmr\Operation\Client\CreateClientOperation());
//
//foreach ($router->getResources() as $resource) {
//    try {
//        $operation = $resource->getOperation($httpMethod, $uri);
//    } catch (\InvalidArgumentException $e) {
//        continue;
//    }
//}
//
//$operation();
