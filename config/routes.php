<?php

return function (Corvus\Core\Application $app, DI\Container $container): void {
    $app->router->map('GET', '/', 'Corvus\Controllers\IndexController::index');

    // User management
    $app->router->map('POST', '/register', 'Corvus\Controllers\UserController::register');
    $app->router->map('POST', '/get-token', 'Corvus\Controllers\UserController::get_token');

    $app->router->group('/', function (\League\Route\RouteGroup $route) use ($app) {

        $route->map('GET', '/me', 'Corvus\Controllers\UserController::me');

        $route->map('GET', '/orders/list', 'Corvus\Controllers\OrderController::index');
        $route->map('POST', '/orders/create', 'Corvus\Controllers\OrderController::create');
        $route->map('GET', '/orders/{id}/show', 'Corvus\Controllers\OrderController::show');

        $route->map('GET', '/products/list', 'Corvus\Controllers\ProductController::index');
        $route->map('GET', '/products/{id}/show', 'Corvus\Controllers\ProductController::show');
    })
        ->middlewares([
            $container->get('Corvus\Middlewares\AuthMiddleware'),
            $container->get('Corvus\Middlewares\AuthPayloadMiddleware'),
            
        ]);
};
