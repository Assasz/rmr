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

        $schemaTool = $this->getSchemaTool();
        $metadata = $this->entityManager->getManager()->getMetadataFactory()->getAllMetadata();

        $schemaTool->createSchema($metadata);
    }

    protected function dropDatabaseSchema(): void
    {
        $schemaTool = $this->getSchemaTool();
        $metadata = $this->entityManager->getManager()->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
    }

    private function getSchemaTool(): SchemaTool
    {
        return new SchemaTool($this->entityManager->getManager());
    }
}
