<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractRepositoryTest extends KernelTestCase
{
    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public function getRepositoryForEntity(string $entityClass): mixed
    {
        return $this->entityManager->getRepository($entityClass);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
