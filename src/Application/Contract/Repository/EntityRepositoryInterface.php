<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Repository;

/**
 * Interface EntityRepositoryInterface
 * @package Rmr\Application\Contract\Repository
 */
interface EntityRepositoryInterface
{
    /**
     * Returns whole entity collection
     *
     * @return array
     */
    public function fetchAll(): array;

    /**
     * Returns entity collection matching given criteria
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function fetchBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array;
}
