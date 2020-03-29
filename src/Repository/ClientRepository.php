<?php

namespace Rmr\Repository;

use Rmr\Contract\Repository\ClientRepositoryInterface;
use Rmr\Entity\Client;

/**
 * Class ClientRepository
 * @package Rmr\Repository
 */
class ClientRepository implements ClientRepositoryInterface
{
    // TODO: Doctrine stuff here - it's infrastructure, above resource layer!

    /**
     * @param int $id
     * @return Client
     */
    public function find($id): Client
    {
        // TODO: Implement find() method.

        return new Client();
    }

    /**
     * @param string $name
     * @return Client
     */
    public function findByName(string $name): Client
    {
        // TODO: Implement findByName() method.

        return new Client();
    }
}
