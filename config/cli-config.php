<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Rmr\Http\Kernel;
use Rmr\Adapter\EntityManagerAdapter;

require __DIR__ . '/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
/** @var EntityManagerAdapter $managerAdapter */
$managerAdapter = (new Kernel())->boot()->getContainer()->get('entity_manager.adapter');

return ConsoleRunner::createHelperSet($managerAdapter->getManager());
