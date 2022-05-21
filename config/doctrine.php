<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

return [

    Doctrine\ORM\EntityManager::class => DI\factory([EntityManager::class, 'create'])
        ->parameter('connection', DI\get('db.params'))
        ->parameter('config', DI\get('doctrine.config')),

        'db.params' => [
            'driver'   => 'pdo_sqlite',
            'url' => 'sqlite:///var/db.sqlite',
        ],

    'doctrine.config' =>
    Setup::createAttributeMetadataConfiguration(array(__DIR__ . "/../src/Entities"), true, null, null, false),
];
