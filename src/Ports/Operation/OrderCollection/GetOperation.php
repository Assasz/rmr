<?php

namespace Rmr\Ports\Operation\OrderCollection;

use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Order\OrderCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/orders",
 *     summary="Retrieves Order collection resource.",
 *     tags={"Order"},
 *     @OA\Response(
 *         response="200",
 *         description="The Order collection resource.",
 *         @OA\JsonContent(type="array",
 *             @OA\Items(ref="#/components/schemas/Order")
 *         ),
 *     )
 * )
 */
final class GetOperation extends AbstractOperation
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
        return $this->normalizeResource($this->resource->retrieve()->toList());
    }
}
