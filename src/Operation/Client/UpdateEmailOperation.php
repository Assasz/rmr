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
     * @return string
     */
    public function __invoke(Request $request): string
    {
        /** @var Client $body */
        $body = $this->deserializeBody($request, Client::class, 'Client', ['groups' => 'updateEmail']);

        $this->validate($body, 'ClientEmail');
        $this->resource->updateEmail($body->getEmail());

        return $this->jsonRepresentation(['client' => (string)$this->resource->retrieve()]);
    }
}
