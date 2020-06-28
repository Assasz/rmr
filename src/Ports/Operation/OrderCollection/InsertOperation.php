<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\OrderCollection;

use Rmr\Domain\Entity\Order;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Order\OrderCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InsertOperation
 * @package Rmr\Ports\Operation\OrderCollection
 */
final class InsertOperation extends AbstractOperation
{
    /** @var OrderCollectionResource */
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
    * @return array
    */
    public function __invoke(Request $request): array
    {
        /** @var Order $order */
        $order = $this->deserializeBody($request, Order::class);

        $this->validate($order, 'Order');
        $this->resource->insert($order);

        return (array)$order;
    }
}
