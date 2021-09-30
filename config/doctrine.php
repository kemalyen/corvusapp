<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

return [

      Doctrine\ORM\EntityManager::class => DI\factory([EntityManager::class, 'create'])
        ->parameter('connection', DI\get('db.params'))
        ->parameter('config', DI\get('doctrine.config')),

        'db.params' => [
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => 'passme',
            'dbname' => 'corvusapp',
            'host' => 'db',
        ],

    'doctrine.config' =>
    Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src/Entities"), true, null, null, false),
  
];
