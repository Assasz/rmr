<?php

namespace Rmr\Contract\Adapter;

/**
 * Interface EntityManagerAdapterInterface
 * @package Rmr\Contract\Adapter
 */
interface EntityManagerAdapterInterface
{
    /**
     * @param object $entity
     */
    public function persist(object $entity): void;
}
