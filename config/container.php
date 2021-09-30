<?php
use Psr\Container\ContainerInterface;

$definitions = [];

$definitions = array_merge(
        require 'config/doctrine.php',
        require 'config/core.php');
 

$containerBuilder = new DI\ContainerBuilder;
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions($definitions);
$container = $containerBuilder->build();
return $container;