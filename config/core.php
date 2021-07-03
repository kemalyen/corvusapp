<?php
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

return [
    'Corvus\Core\Application' => function (ContainerInterface $c) {
        return new Corvus\Core\Application();
    },

    'Corvus\Middleware\AuthMiddleware' => function () {
        return new Corvus\Middleware\AuthMiddleware('!secReT$123*', 'jwt');
    },
    

    Twig\Environment::class => function (ContainerInterface $c) {
        $loader = new Twig\Loader\FilesystemLoader(__DIR__ . "/../templates");
        $twig = new Twig\Environment($loader, [
            __DIR__ . '/../var/cache'
        ]);
        $twig->enableDebug();
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        return $twig;
    },    

 
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('mylog');

        $fileHandler = new StreamHandler('var/logs/app.log', Logger::DEBUG);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        return $logger;
    }),

];
