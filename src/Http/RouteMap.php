<?php

namespace Rmr\Http;

use Rmr\Operation\Client\CreateClientOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Rmr\Resource\Client\ClientResource;

/**
 * Class RouteMap
 * @package Rmr\Http
 */
final class RouteMap
{
    /**
     * Returns route map, where operations are mapped to resources
     *
     * @return array
     */
    public function get(): array
    {
        return [
            ClientResource::class => [
                // TODO: add some operations
            ],
            ClientCollectionResource::class => [
                CreateClientOperation::class
            ]
        ];
    }
}
