<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Application\Contract\Adapter;

/**
 * Trait EntityManagerAwareTrait
 * @package Rmr\Application\Contract\Adapter
 */
trait EntityManagerAwareTrait
{
    /** @var EntityManagerAdapterInterface */
    private $entityManager;

    /**
     * @required
     * @param EntityManagerAdapterInterface $entityManager
     */
    public function setEntityManager(EntityManagerAdapterInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
