<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Http;

use Rmr\Operation\ClientCollection\CreateOperation;
use Rmr\Operation\ClientCollection\GetAllOperation;
use Rmr\Operation\Client\GetOperation;
use Rmr\Operation\Client\RemoveOperation;
use Rmr\Operation\Client\ReplaceOperation;
use Rmr\Operation\Client\UpdateEmailOperation;
use Rmr\Resource\Client\ClientCollectionResource;
use Rmr\Resource\Client\ClientResource;

/**
 * Class RouteMap
 * @package Rmr\Http
 */
class RouteMap
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
                GetOperation::class,
                RemoveOperation::class,
                ReplaceOperation::class,
                UpdateEmailOperation::class
            ],
            ClientCollectionResource::class => [
                GetAllOperation::class,
                CreateOperation::class
            ]
        ];
    }
}
