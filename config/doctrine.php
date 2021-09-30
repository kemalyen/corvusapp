<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

return [

    Doctrine\ORM\EntityManager::class => DI\factory([EntityManager::class, 'create'])
        ->parameter('connection', DI\get('db.params'))
        ->parameter('config', DI\get('doctrine.config')),

    'db.params' => [
        'driver' => DI\get('DB_DRIVER'),
        'user' => DI\get('DB_USERNAME'),
        'password' => DI\get('DB_PASSWORD'),
        'dbname' => DI\get('DB_DATABASE'),
        'host' => DI\get('DB_HOST'),
    ],

    'doctrine.config' =>
    Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src/Entities"), true, null, null, false),
];
