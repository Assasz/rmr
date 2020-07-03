<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use PHPUnit\Framework\TestCase;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Rmr\Infrastructure\Http\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ApiTestCase extends TestCase
{
    use ApiAssertionsTrait;
    use DatabaseRefreshableTrait;

    protected ?ContainerInterface $container;
    protected ?HttpClient $client;
    protected ?EntityManagerAdapter $entityManager;

    public function setUp(): void
    {
        $kernel = (new Kernel())->boot('test');

        $this->container = $kernel->getContainer();
        $this->client = new HttpClient($kernel);
        $this->entityManager = $this->container->get('entity_manager.adapter');

        $this->recreateDatabaseSchema();
    }

    public function tearDown(): void
    {
        $this->dropDatabaseSchema();

        $this->container = $this->client = $this->entityManager = null;
    }
}
