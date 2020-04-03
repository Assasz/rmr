<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Operation\ResourceOperationInterface;
use Rmr\Representation\ClientRepresentation;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param Request $request
     * @return ClientRepresentation
     */
    public function __invoke(Request $request): ClientRepresentation
    {
        $client = (new Client())
            ->setFirstname($request->request->get('firstname'))
            ->setLastname($request->request->get('lastname'));

        $this->resource->insert($client);

        return new ClientRepresentation($client);
    }
}
