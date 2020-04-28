<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Tests\Application\Resource\Client;

use PHPUnit\Framework\TestCase;
use Rmr\Application\Contract\Repository\ClientRepositoryInterface;
use Rmr\Domain\Entity\Client;
use Rmr\Infrastructure\Http\Exception\NotFoundHttpException;
use Rmr\Application\Resource\Client\ClientResource;

/**
 * Class ClientResourceTest
 * @package Rmr\Tests\Application\Resource\Client
 */
class ClientResourceTest extends TestCase
{
    /**
     * @covers \Rmr\Application\Resource\Client\ClientResource::retrieve
     * @throws \ReflectionException
     */
    public function testItRetrievesClient(): void
    {
        $repositoryMock = $this->createMock(ClientRepositoryInterface::class);
        $repositoryMock->expects($this->once())->method('pick')->with(1)->willReturn((new Client())->setEmail('john@doe.com'));

        $resource = new ClientResource($repositoryMock);
        $resource->id = 1;

        $client = $resource->retrieve();

        $this->assertEquals('john@doe.com', $client->getEmail());
    }

    /**
     * @covers \Rmr\Application\Resource\Client\ClientResource::retrieve
     * @throws \ReflectionException
     */
    public function testItThrowsNotFoundHttpExceptionOnNonExistentClient(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $repositoryMock = $this->createMock(ClientRepositoryInterface::class);
        $repositoryMock->expects($this->once())->method('pick')->with(1)->willReturn(null);

        $resource = new ClientResource($repositoryMock);
        $resource->id = 1;

        $resource->retrieve();
    }
}
