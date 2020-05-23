<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Resource\Order;

use Cake\Collection\Collection;
use Rmr\Application\Contract\Adapter\EntityManagerAwareTrait;
use Rmr\Application\Contract\Repository\OrderRepositoryInterface;
use Rmr\Domain\Entity\Order;
use Rmr\Application\Resource\AbstractResource;
use Rmr\Application\Resource\CollectionResourceInterface;

/**
 * Class OrderCollectionResource
 * @package Rmr\Application\Resource\Order
 */
class OrderCollectionResource extends AbstractResource implements CollectionResourceInterface
{
    use EntityManagerAwareTrait;

    private OrderRepositoryInterface $orderRepository;

    /**
     * OrderCollectionResource constructor.
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/orders';
    }

    /**
     * {@inheritdoc}
     */
    public function supports($item): bool
    {
        return $item instanceof Order;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(): Collection
    {
        return new Collection($this->orderRepository->fetchAll());
    }

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function replace($item): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function insert($item): void
    {
        // TODO: Implement insert() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save(): void
    {
        $this->entityManager->flush();
    }
}
