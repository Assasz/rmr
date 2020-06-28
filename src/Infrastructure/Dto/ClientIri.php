<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Dto;

use Rmr\Domain\Entity\Client;
use Rmr\Application\Resource\Client\ClientResource;

/**
 * Class ClientIri
 * @package Rmr\Infrastructure\Dto
 *
 * @OA\Schema()
 */
final class ClientIri
{
    /**
     * @OA\Property(
     *     type="string",
     *     example="/clients/1"
     * )
     */
    public string $client;

    /**
     * ClientIri constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = ClientResource::PATH . $client->getId();
    }
}
