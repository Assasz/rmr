<?php

namespace Rmr\Contract\Repository;

/**
 * Interface EntityRepositoryInterface
 * @package Rmr\Contract\Repository
 */
interface EntityRepositoryInterface
{
    public function findAll(): array;

    public function findBy(array $criteria): array;
}
