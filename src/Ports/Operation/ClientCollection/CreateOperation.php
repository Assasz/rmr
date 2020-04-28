<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\ClientCollection;

use Rmr\Domain\Entity\Client;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Ports\Operation\Dto\ClientIri;
use Rmr\Application\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateOperation
 * @package Rmr\Ports\Operation\Client
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
     * @return ClientIri
     */
    public function __invoke(Request $request): ClientIri
    {
        /** @var Client $client */
        $client = $this->deserializeBody($request, Client::class);

        $this->validate($client, 'Client');
        $this->resource->insert($client);

        return new ClientIri($client);
    }
}
