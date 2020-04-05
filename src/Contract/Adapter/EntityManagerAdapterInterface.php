<?php

namespace Rmr\Contract\Adapter;

/**
 * Interface EntityManagerAdapterInterface
 * @package Rmr\Contract\Adapter
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
     * Saves changes made to entity objects
     */
    public function flush(): void;
}
