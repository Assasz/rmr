<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Repository;

use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Rmr\Application\Contract\Repository\OrderRepositoryInterface;
use Rmr\Domain\Entity\Order;

/**
 * Class OrderRepository
 * @package Rmr\Infrastructure\Repository
 * @method find($id, $lockMode = null, $lockVersion = null): ?Order
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
