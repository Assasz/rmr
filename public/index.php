<?php

require dirname(__DIR__) . '/config/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Rmr\Http\Kernel;

$kernel = (new Kernel())->boot($_ENV['APP_ENV'] ?? 'dev');
$kernel->handleRequest(Request::createFromGlobals())->send();
$kernel->shutdown();
