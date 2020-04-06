<?php

namespace Rmr\Operation\ClientCollection;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateOperation
 * @package Rmr\Operation\Client
 */
class CreateOperation extends AbstractOperation
{

    /** @var ClientCollectionResource */
    protected $resource;

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

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_CREATED;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): string
    {
        // TODO: validation
        $client = $this->deserializeBody($request, Client::class);
        $this->resource->insert($client);

        return $this->jsonRepresentation(['client' => (string)$client]);
    }
}
