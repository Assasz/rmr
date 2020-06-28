<?php

namespace Rmr\Ports\Operation\Client;

use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Application\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/clients/{id}",
 *     summary="Retrieves given Client resource.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="The Client resource.",
 *         @OA\JsonContent(ref="#/components/schemas/Client"),
 *     )
 * )
 */
final class GetOperation extends AbstractOperation
{
    /** @var ClientResource */
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
        return $this->normalizeResource($this->resource->retrieve());
    }
}
