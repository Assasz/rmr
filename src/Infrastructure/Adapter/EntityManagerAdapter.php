<?php
/**
 * Copyright (c) 2020.
 * @author Paweł Antosiak <contact@pawelantosiak.com>
 */

namespace Rmr\Infrastructure\Adapter;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Rmr\Application\Contract\Adapter\EntityManagerAdapterInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

/**
 * Class EntityManagerAdapter
 *
 * Provides access to Doctrine Entity Manager
 *
 * @package Rmr\Infrastructure\Adapter
 */
class EntityManagerAdapter implements EntityManagerAdapterInterface
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * EntityManagerAdapter constructor.
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $this->setup();
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function replace(object $entity): void
    {
        $this->entityManager->merge($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \RuntimeException
     */
    private function setup(): void
    {
        if (false === array_key_exists('DATABASE_URL', $_ENV)) {
            throw new \RuntimeException('Variable DATABASE_URL need to be defined in .env file.');
        }

        $entityNamespace = 'Rmr\Domain\Entity';
        $mappingPath = dirname(__DIR__, 3) . '/config/orm';

        $driver = new SimplifiedYamlDriver([$mappingPath => $entityNamespace]);

        $config = Setup::createConfiguration();
        $config->setMetadataDriverImpl($driver);
        $config->addEntityNamespace('Entity', $entityNamespace);
        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        $connection = DriverManager::getConnection(['url' => $_ENV['DATABASE_URL']], $config);

        $this->entityManager = EntityManager::create($connection, $config);
    }
}
