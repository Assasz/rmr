<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Api\ClientCollection;

use Rmr\Domain\Entity\Client;
use Rmr\Tests\Functional\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    public function testStructure(): void
    {
        $response = $this->client->request('GET', '/clients');

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertMatchesCollectionJsonSchema($response, Client::class);
    }
}
