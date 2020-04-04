<?php

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateClientOperation
 * @package Rmr
 */
class CreateOperation extends AbstractOperation
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
     * @return string
     */
    public function __invoke(Request $request): string
    {
        $client = (new Client())
            ->setFirstname($request->request->get('firstname'))
            ->setLastname($request->request->get('lastname'));

        $this->resource->insert($client);

        return (string)$client;
    }
}
