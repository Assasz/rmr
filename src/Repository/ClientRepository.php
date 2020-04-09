<?php

namespace Rmr\Repository;

use Rmr\Adapter\EntityManagerAdapter;
use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;

/**
 * Class ClientRepository
 * @package Rmr\Repository
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
