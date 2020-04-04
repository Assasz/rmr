<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Rmr\Http\Kernel;

require __DIR__ . '/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = (new Kernel())->boot()->getContainer()->get('entity_manager.adapter')->getManager();

return ConsoleRunner::createHelperSet($entityManager);
