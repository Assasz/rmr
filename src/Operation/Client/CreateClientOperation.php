<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Operation\ResourceOperationInterface;
use Rmr\Resource\AbstractResource;
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
        return AbstractResource::POST_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * @return Client
     */
    public function __invoke(): Client
    {
        $client = new Client();
        $client->firstname = $this->request['firstname'];
        $client->lastname = $this->request['lastname'];

        return $client;
    }
}
