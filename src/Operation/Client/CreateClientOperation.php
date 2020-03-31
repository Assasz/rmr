<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Operation\ResourceOperationInterface;
use Rmr\Resource\Client\ClientCollectionResource;

/**
 * Class CreateClientOperation
 * @package Rmr
 */
class CreateClientOperation extends AbstractOperation implements ResourceOperationInterface
{
    /** @var ClientCollectionResource */
    private $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::POST_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    // operation __invoke method should always return void

    public function __invoke(): void
    {
        $client = (new Client())
            ->setFirstname($this->request['firstname'])
            ->setLastname($this->request['lastname']);

        $this->resource->insert($client);
    }
}
