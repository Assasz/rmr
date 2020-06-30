<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use PHPUnit\Framework\TestCase;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Rmr\Infrastructure\Http\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ApiTestCase extends TestCase
{
    use ApiAssertionsTrait;

    protected ?HttpClientInterface $client;
    protected ?ContainerInterface $container;
    protected ?EntityManagerAdapter $entityManager;

    private const REQUEST_HEADERS = [
        'Accept' => 'application/json',
    ];

    public function setUp(): void
    {
        if (false === array_key_exists('BASE_URI', $_ENV)) {
            throw new \RuntimeException('BASE_URI variable needs to be defined in your .env.test file.');
        }

        $this->container = (new Kernel())->boot('test')->getContainer();
        $this->entityManager = $this->container->get('entity_manager.adapter');
        $this->client = HttpClient::createForBaseUri($_ENV['BASE_URI'], ['headers' => self::REQUEST_HEADERS]);

        $this->entityManager->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->entityManager->rollback();

        $this->container = $this->entityManager = $this->client = null;
    }
}
