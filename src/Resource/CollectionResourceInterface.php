<?php

namespace Rmr\Resource;

/**
 * Interface CollectionResourceInterface
 * @package Rmr\Resource
 */
interface CollectionResourceInterface extends ResourceInterface
{
    /**
     * Inserts new item to the resource collection
     * POST /resources
     *
     * @param mixed $item
     */
    public function insert($item): void;
}
