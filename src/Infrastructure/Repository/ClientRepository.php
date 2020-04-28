<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Repository;

use Rmr\Infrastructure\Adapter\EntityManagerAdapter;
use Rmr\Application\Contract\Repository\ClientRepositoryInterface;
use Rmr\Domain\Entity\Client;

/**
 * Class ClientRepository
 * @package Rmr\Infrastructure\Repository
 */
class ClientRepository extends AbstractEntityRepository implements ClientRepositoryInterface
{
    /**
     * ClientRepository constructor.
     * @param EntityManagerAdapter $managerAdapter
     */
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct($managerAdapter, Client::class);
    }

    /**
     * {@inheritdoc}
     */
    public function pick(int $id): ?Client
    {
        return $this->find($id);
    }
}
