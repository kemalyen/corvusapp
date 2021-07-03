<?php

return function (Corvus\Core\Application $app, DI\Container $container): void {
    $app->router->map('GET', '/', 'Corvus\Controller\IndexController::index');
    $app->router->map('POST', '/get-token', 'Corvus\Controller\UserController::get_token');
    $app->router->map('POST', '/create', 'Corvus\Controller\UserController::create');

    $app->router->map('GET', '/me', 'Corvus\Controller\UserController::me')
        ->middlewares(
            [
                $container->get('Corvus\Middleware\AuthMiddleware'),
                $container->get('Corvus\Middleware\AuthPayloadMiddleware')
            ]);

    $app->router->map('GET', '/products', 'Corvus\Controller\ProductController::index');
    $app->router->map('GET', '/products/{id}/show', 'Corvus\Controller\ProductController::show');
};
