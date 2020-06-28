<?php

namespace Rmr\Ports\Operation\ClientCollection;

use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/clients",
 *     summary="Retrieves Client collection resource.",
 *     tags={"Client"},
 *     @OA\Response(
 *         response="200",
 *         description="The Client collection resource.",
 *         @OA\JsonContent(type="array",
 *             @OA\Items(ref="#/components/schemas/Client")
 *         ),
 *     )
 * )
 */
final class GetOperation extends AbstractOperation
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
        return $this->normalizeResource($this->resource->retrieve()->toList());
    }
}
