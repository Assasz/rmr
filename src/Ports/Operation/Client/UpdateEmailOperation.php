<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Ports\Operation\Client;

use Rmr\Domain\Entity\Client;
use Rmr\Infrastructure\Dto\NewEmail;
use Rmr\Ports\Operation\AbstractOperation;
use Rmr\Infrastructure\Dto\ClientIri;
use Rmr\Application\Resource\Client\ClientResource;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Patch(
 *     path="/clients/{id}/email",
 *     summary="Modifies email of given Client resource.",
 *     tags={"Client"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/NewEmail"),
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Modified Client resource IRI.",
 *         @OA\JsonContent(ref="#/components/schemas/ClientIri"),
 *     )
 * )
 */
final class UpdateEmailOperation extends AbstractOperation
{
    /** @var ClientResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PATCH_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/email';
    }

    /**
     * @param Request $request
     * @return ClientIri
     */
    public function __invoke(Request $request): ClientIri
    {
        /** @var NewEmail $newEmail */
        $newEmail = $this->deserializeBody($request, NewEmail::class);

        $this->validate($newEmail, 'ClientEmail');
        $this->resource->updateEmail($newEmail->email);

        return new ClientIri($this->resource->retrieve());
    }
}
