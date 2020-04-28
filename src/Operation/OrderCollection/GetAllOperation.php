<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Operation\OrderCollection;

use Rmr\Operation\AbstractOperation;
use Rmr\Resource\Order\OrderCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetAllOperation
 * @package Rmr\Operation\OrderCollection
 */
class GetAllOperation extends AbstractOperation
{
    /** @var OrderCollectionResource */
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
        return $this->normalizeResource($this->resource->retrieve()->toList(), 'Order', ['groups' => 'read']);
    }
}
