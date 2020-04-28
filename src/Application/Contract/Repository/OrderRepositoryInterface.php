<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Repository;

use Rmr\Domain\Entity\Order;

/**
 * Interface OrderRepositoryInterface
 * @package Rmr\Application\Contract\Repository
 */
interface OrderRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Returns Order entity object by given identifier or NULL if order does not exist
     *
     * @param int $id
     * @return Order|null
     */
    public function pick(int $id): ?Order;
}
