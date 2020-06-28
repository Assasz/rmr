<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Rmr\Infrastructure\Http\Kernel;
use Rmr\Infrastructure\Utils\Debug;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;

require __DIR__ . '/bootstrap.php';

Debug::cli();

/** @var EntityManagerAdapter $managerAdapter */
$managerAdapter = (new Kernel())->boot()->getContainer()->get('entity_manager.adapter');

return ConsoleRunner::createHelperSet($managerAdapter->getManager());
