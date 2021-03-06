<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Api\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Tests\Functional\Framework\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients/1';

    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager->loadFixtures(['clients.yaml']);
    }

    public function testStructure(): void
    {
        $response = $this->client->request('GET', self::ENDPOINT_URI);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertMatchesItemJsonSchema($response, Client::class);
    }
}
