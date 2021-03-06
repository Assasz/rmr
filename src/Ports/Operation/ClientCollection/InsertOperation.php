<?php

namespace Rmr\Ports\Operation\ClientCollection;

use Rmr\Domain\Entity\Client;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Infrastructure\Dto\ClientIri;
use Rmr\Application\Resource\Client\ClientCollectionResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/clients",
 *     summary="Inserts new Client item into collection resource.",
 *     tags={"Client"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/Client"),
 *     ),
 *     @OA\Response(
 *         response="201",
 *         description="Inserted Client resource IRI.",
 *         @OA\JsonContent(ref="#/components/schemas/ClientIri"),
 *     )
 * )
 */
final class InsertOperation extends AbstractOperation
{
    /** @var ClientCollectionResource */
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
     * @return ClientIri
     */
    public function __invoke(Request $request): ClientIri
    {
        /** @var Client $client */
        $client = $this->deserializeBody($request, Client::class);

        $this->validate($client, 'Client');
        $this->resource->insert($client);

        return new ClientIri($client);
    }
}
