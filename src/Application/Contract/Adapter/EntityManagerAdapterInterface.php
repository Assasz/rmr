<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Adapter;

/**
 * Interface EntityManagerAdapterInterface
 * @package Rmr\Application\Contract\Adapter
 */
interface EntityManagerAdapterInterface
{
    /**
     * Persists entity object
     *
     * @param object $entity
     */
    public function persist(object $entity): void;

    /**
     * Removes entity object
     *
     * @param object $entity
     */
    public function remove(object $entity): void;

    /**
     * Merges provided entity object into persistence context
     *
     * @param object $entity
     */
    public function replace(object $entity): void;

    /**
     * Saves changes made to entity objects
     */
    public function flush(): void;
}
