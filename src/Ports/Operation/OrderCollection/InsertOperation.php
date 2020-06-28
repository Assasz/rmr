<?php

namespace Rmr\Ports\Operation\OrderCollection;

use Rmr\Domain\Entity\Order;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Order\OrderCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/orders",
 *     summary="Inserts new Order item into collection resource.",
 *     tags={"Order"},
 *     @OA\Response(
 *         response="201",
 *         description="Inserted Order resource IRI.",
 *     )
 * )
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
     * @return string
     */
    public function __invoke(Request $request): string
    {
        /** @var Order $order */
        $order = $this->deserializeBody($request, Order::class);

        $this->validate($order, 'Order');
        $this->resource->insert($order);

        return $this->resource->getPath() . $order->getId();
    }
}
