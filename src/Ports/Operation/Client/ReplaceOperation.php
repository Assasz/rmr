<?php

namespace Rmr\Ports\Operation\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Infrastructure\Dto\ClientIri;
use Rmr\Application\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Put(
 *     path="/clients/{id}",
 *     summary="Replaces given Client resource with new one.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/Client"),
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Replaced Client resource IRI.",
 *         @OA\JsonContent(ref="#/components/schemas/ClientIri"),
 *     )
 * )
 */
final class ReplaceOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PUT_METHOD;
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
     * @return ClientIri
     */
    public function __invoke(Request $request): ClientIri
    {
        $client = $this->resource->retrieve();

        /** @var Client $newClient */
        $newClient = $this->deserializeBody($request, Client::class);
        $newClient->setId($client->getId());

        $this->validate($newClient, 'Client');
        $this->resource->replace($newClient);

        return new ClientIri($newClient);
    }
}
