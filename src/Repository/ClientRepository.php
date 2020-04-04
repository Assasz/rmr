<?php

namespace Rmr\Repository;

use Doctrine\Persistence\ManagerRegistry;
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
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
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
