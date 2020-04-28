<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\ClientCollection;

use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetAllOperation
 * @package Rmr\Ports\Operation\ClientCollection
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
        return $this->normalizeResource($this->resource->retrieve()->toList(), 'Client', ['groups' => 'read']);
    }
}
