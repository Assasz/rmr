<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReplaceOperation
 * @package Rmr\Operation\Client
 */
class ReplaceOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PUT_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request): array
    {
        // TODO: validation
        $client = $this->resource->retrieve();

        /** @var Client $newClient */
        $newClient = $this->deserializeBody($request, Client::class);
        $newClient->setId($client->getId());

        $this->resource->replace($newClient);

        return ['client' => (string)$newClient];
    }
}
