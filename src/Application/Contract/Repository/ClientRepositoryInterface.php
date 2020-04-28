<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Repository;

use Rmr\Domain\Entity\Client;

/**
 * Interface ClientRepositoryInterface
 * @package Rmr\Application\Contract\Repository
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
