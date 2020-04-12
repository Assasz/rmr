<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Contract\Repository;

use Rmr\Entity\Client;

/**
 * Interface ClientRepositoryInterface
 * @package Rmr\Contract\Repository
 */
interface ClientRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * Returns Client entity object by given identifier or NULL if client does not exist
     *
     * @param int $id
     * @return Client|null
     */
    public function pick(int $id): ?Client;
}
