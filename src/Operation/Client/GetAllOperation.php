<?php

namespace Rmr\Operation\Client;

use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetAllOperation
 * @package Rmr\Operation\Client
 */
class GetAllOperation extends AbstractOperation
{
    /** @var ClientCollectionResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::GET_METHOD;
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
        return $this->arrayRepresentation($this->resource->retrieve()->toList(), 'Client', ['groups' => 'read']);
    }
}
