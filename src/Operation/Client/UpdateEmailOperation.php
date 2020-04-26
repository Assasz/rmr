<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Operation\Client;

use Rmr\Entity\Client;
use Rmr\Operation\AbstractOperation;
use Rmr\Operation\Dto\ClientIri;
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
     * @return ClientIri
     */
    public function __invoke(Request $request): ClientIri
    {
        /** @var Client $body */
        $body = $this->deserializeBody($request, Client::class, 'Client', ['groups' => 'updateEmail']);

        $this->validate($body, 'ClientEmail');
        $this->resource->updateEmail($body->getEmail());

        return new ClientIri($this->resource->retrieve());
    }
}
