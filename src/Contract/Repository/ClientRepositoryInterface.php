<?php

namespace Rmr\Contract\Repository;

use Rmr\Entity\Client;

/**
 * Interface ClientRepositoryInterface
 * @package Rmr\Contract\Repository
 */
interface ClientRepositoryInterface extends EntityRepositoryInterface
{
    public function findByName(string $name): Client;

    public function find(int $id): Client;
}
