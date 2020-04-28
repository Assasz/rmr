<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Repository;

use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Rmr\Application\Contract\Repository\ProductRepositoryInterface;
use Rmr\Domain\Entity\Product;

/**
 * Class ProductRepository
 * @package Rmr\Infrastructure\Repository
 */
class ProductRepository extends AbstractEntityRepository implements ProductRepositoryInterface
{
    /**
     * ProductRepository constructor.
     * @param EntityManagerAdapter $managerAdapter
     */
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct($managerAdapter, Product::class);
    }

    /**
     * {@inheritdoc}
     */
    public function pick(int $id): ?Product
    {
        return $this->find($id);
    }
}
