<?php

namespace Rmr\Operation\ClientCollection;

use Rmr\Operation\AbstractOperation;
use Rmr\Operation\JsonRepresentableTrait;
use Rmr\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetAllOperation
 * @package Rmr\Operation\ClientCollection
 */
class GetAllOperation extends AbstractOperation
{
    use JsonRepresentableTrait;

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
     * @return string
     */
    public function __invoke(Request $request): string
    {
        return $this->jsonRepresentation($this->resource->retrieve()->toList(), 'Client', ['groups' => 'read']);
    }
}
