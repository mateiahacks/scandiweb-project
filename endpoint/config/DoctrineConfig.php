<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class DoctrineConfig {
    private $isDevMode;
    private $entityManager;

    public function __construct(bool $isDevMode) {
        $this->isDevMode = $isDevMode;
        $this->entityManager = $this->setupEntityManager();
    }

    private function setupEntityManager() {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__."/../src"),
            isDevMode: $this->isDevMode,
        );

        $cache = new FilesystemAdapter();

        $config->setMetadataCache($cache);

        // Database connection configuration
        $conn = [
            'driver'   => 'pdo_mysql',
            'host'     => $_ENV['DB_HOST'],
            'dbname'   => $_ENV['DB_NAME'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
        ];

        $connection = DriverManager::getConnection($conn);

        return new EntityManager($connection, $config);
    }

    public function getEntityManager() {
        return $this->entityManager;
    }
}
