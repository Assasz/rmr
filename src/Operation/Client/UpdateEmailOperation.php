<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEmailOperation
 * @package Rmr\Operation\Client
 */
class UpdateEmailOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PATCH_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/email';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request): array
    {
        // TODO: validation

        /** @var Client $body */
        $body = $this->deserializeBody($request, Client::class, 'Client', ['groups' => 'updateEmail']);

        $client = $this->resource->retrieve();
        $client->setEmail($body->getEmail());

        $this->resource->save();

        return ['client' => (string)$client];
    }
}
