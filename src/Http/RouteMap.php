<?php

namespace Rmr\Http;

use Rmr\Operation\Client\CreateOperation;
use Rmr\Operation\Client\GetAllOperation;
use Rmr\Operation\Client\GetOperation;
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
                GetOperation::class
            ],
            ClientCollectionResource::class => [
                GetAllOperation::class,
                CreateOperation::class
            ]
        ];
    }
}
