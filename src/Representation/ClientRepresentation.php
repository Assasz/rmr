<?php

namespace Rmr\Representation;

use Rmr\Entity\Client;

/**
 * Class ClientRepresentation
 * @package Rmr\Representation
 */
final class ClientRepresentation implements JsonRepresentationInterface
{
    /** @var Client */
    private $client;

    /**
     * ClientRepresentation constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(): string
    {
        return '';
    }
}
