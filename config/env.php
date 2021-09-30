<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();

return [
    'DB_DRIVER' => $_ENV['DB_DRIVER'],
    'DB_HOST' => $_ENV['DB_HOST'],
    'DB_DATABASE' => $_ENV['DB_DATABASE'],
    'DB_USERNAME' => $_ENV['DB_USERNAME'],
    'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
    'JWT_SECRET' => $_ENV['JWT_SECRET'],
    'JWT_TOKEN_KEY' => $_ENV['JWT_TOKEN_KEY']
];