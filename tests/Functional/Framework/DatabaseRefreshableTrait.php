<?php

declare(strict_types=1);

namespace Rmr\Tests\Functional\Framework;

use Doctrine\ORM\Tools\SchemaTool;
use Rmr\Infrastructure\Adapter\EntityManagerAdapter;

trait DatabaseRefreshableTrait
{
    protected ?EntityManagerAdapter $entityManager;

    protected function recreateDatabaseSchema(): void
    {
        $this->dropDatabaseSchema();

        $metadata = $this->entityManager->getManager()->getMetadataFactory()->getAllMetadata();
        $this->getSchemaTool()->createSchema($metadata);
    }

    protected function dropDatabaseSchema(): void
    {
        $metadata = $this->entityManager->getManager()->getMetadataFactory()->getAllMetadata();
        $this->getSchemaTool()->dropSchema($metadata);
    }

    private function getSchemaTool(): SchemaTool
    {
        return new SchemaTool($this->entityManager->getManager());
    }
}
