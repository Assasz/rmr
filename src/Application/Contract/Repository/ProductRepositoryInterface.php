<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Repository;

use Rmr\Domain\Entity\Product;

/**
 * Interface ProductRepositoryInterface
 * @package Rmr\Application\Contract\Repository
 */
interface ProductRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Returns Product entity object by given identifier or NULL if product does not exist
     *
     * @param int $id
     * @return Product|null
     */
    public function pick(int $id): ?Product;
}
