<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Api\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Infrastructure\Repository\ClientRepository;
use Rmr\Tests\Functional\Framework\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients/%d';

    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager->loadFixtures(['clients.yaml']);
    }

    public function testStructure(): void
    {
        /** @var Client $targetClient */
        $targetClient = $this->container->get(ClientRepository::class)->findOneBy(['email' => 'test@gmail.com']);

        $response = $this->client->request(
            'GET',
            sprintf(self::ENDPOINT_URI, $targetClient->getId())
        );

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertMatchesItemJsonSchema($response, Client::class);
    }
}
