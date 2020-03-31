<?php

namespace Rmr\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Rmr\Contract\Adapter\EntityManagerAdapterInterface;

/**
 * Class EntityManagerAdapter
 * @package Rmr\Adapter
 */
class EntityManagerAdapter implements EntityManagerAdapterInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param object $entity
     */
    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
