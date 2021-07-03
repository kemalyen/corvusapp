<?php

return function (Corvus\Core\Application $app, DI\Container $container): void {
    $app->router->middlewares(
        [
            $container->get('Mezzio\Helper\BodyParams\BodyParamsMiddleware'),
            $container->get('Corvus\Middleware\LoggerMiddleware'),
        ]);
};
