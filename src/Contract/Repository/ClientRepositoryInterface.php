<?php

namespace Rmr\Contract\Repository;

use Rmr\Entity\Client;
use Rmr\Http\Exception\NotFoundHttpException;

/**
 * Interface ClientRepositoryInterface
 * @package Rmr\Contract\Repository
 */
interface ClientRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Returns Client entity object by given name
     *
     * @param string $name in format 'Firstname Lastname'
     * @return Client
     * @throws NotFoundHttpException
     */
    public function findByName(string $name): Client;

    /**
     * Returns Client entity object by given identifier
     *
     * @param int $id
     * @return Client
     * @throws NotFoundHttpException
     */
    public function pick(int $id): Client;
}
