<?php

namespace Rmr\Contract\Adapter;

/**
 * Trait EntityManagerAwareTrait
 * @package Rmr\Contract\Adapter
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
