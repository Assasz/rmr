<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Infrastructure\Dto\ClientIri;
use Rmr\Application\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEmailOperation
 * @package Rmr\Ports\Operation\Client
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
