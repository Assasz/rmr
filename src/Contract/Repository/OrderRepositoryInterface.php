<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Contract\Repository;

use Rmr\Entity\Order;

/**
 * Interface OrderRepositoryInterface
 * @package Rmr\Contract\Repository
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
