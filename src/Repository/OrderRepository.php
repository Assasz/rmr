<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Repository;

use Rmr\Adapter\EntityManagerAdapter;
use Rmr\Contract\Repository\OrderRepositoryInterface;
use Rmr\Entity\Order;

/**
 * Class OrderRepository
 * @package Rmr\Repository
 */
class OrderRepository extends AbstractEntityRepository implements OrderRepositoryInterface
{
    /**
     * ProductRepository constructor.
     * @param EntityManagerAdapter $managerAdapter
     */
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct($managerAdapter, Order::class);
    }

    /**
     * {@inheritdoc}
     */
    public function pick(int $id): ?Order
    {
        return $this->find($id);
    }
}
