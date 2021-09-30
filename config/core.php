<?php
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

return [
    'Corvus\Core\Application' => function (ContainerInterface $c) {
        return new Corvus\Core\Application();
    },

    'Corvus\Middlewares\AuthMiddleware' => function (ContainerInterface $c) {
        return new Corvus\Middlewares\AuthMiddleware($c->get('JWT_SECRET'), $c->get('JWT_TOKEN_KEY'));
    },
 
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('mylog');

        $fileHandler = new StreamHandler('var/logs/app.log', Logger::DEBUG);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        return $logger;
    }),

];