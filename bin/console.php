#!/usr/bin/env php
<?php

use Rmr\Infrastructure\Http\Kernel;
use Rmr\Infrastructure\Utils\Debug;
use Symfony\Component\Console\Application;
use Rmr\Ports\Command\LoadFixturesCommand;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;

require dirname(__DIR__) . '/config/bootstrap.php';

Debug::cli();

/** @var EntityManagerAdapter $managerAdapter */
$managerAdapter = (new Kernel())->boot()->getContainer()->get('entity_manager.adapter');

$application = new Application();
$application->add(new LoadFixturesCommand($managerAdapter));

$application->run();
