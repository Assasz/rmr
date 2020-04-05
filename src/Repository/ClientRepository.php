<?php

namespace Rmr\Repository;

use Rmr\Adapter\EntityManagerAdapter;
use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;
use Rmr\Http\Exception\NotFoundHttpException;

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
    public function pick($id): Client
    {
        $client = $this->find($id);

        if (!$client instanceof Client) {
            throw new NotFoundHttpException();
        }

        return $client;
    }
}
