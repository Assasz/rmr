<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Operation\Dto;

use Rmr\Domain\Entity\Client;
use Rmr\Application\Resource\Client\ClientResource;

/**
 * Class ClientIri
 * @package Rmr\Operation\Dto
 */
final class ClientIri
{
    /** @var string */
    public $client;

    /**
     * ClientIri constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = ClientResource::ROOT_PATH . $client->getId();
    }
}
