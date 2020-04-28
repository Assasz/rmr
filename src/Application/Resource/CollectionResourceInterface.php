<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Resource;

/**
 * Interface CollectionResourceInterface
 * @package Rmr\Application\Resource
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
