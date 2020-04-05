<?php

namespace Rmr\Repository;

use Doctrine\ORM\EntityRepository;
use Rmr\Adapter\EntityManagerAdapter;
use Rmr\Contract\Repository\EntityRepositoryInterface;

/**
 * Class AbstractEntityRepository
 *
 * Repository base class with a simplified constructor (for autowiring)
 *
 * @package Rmr\Repository
 */
abstract class AbstractEntityRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * AbstractEntityRepository constructor.
     * @param EntityManagerAdapter $managerAdapter
     * @param string $entityClass
     */
    public function __construct(EntityManagerAdapter $managerAdapter, string $entityClass)
    {
        $manager = $managerAdapter->getManager();

        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(): array
    {
        return $this->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }
}
