<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Api\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Tests\Functional\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    public function testStructure(): void
    {
        $response = $this->client->request('GET', '/clients/1');

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertMatchesItemJsonSchema($response, Client::class);
    }
}
