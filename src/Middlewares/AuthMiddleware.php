<?php declare(strict_types=1);

namespace Corvus\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use PsrJwt\Auth\Authorise;
use PsrJwt\JwtAuthMiddleware;
use Nyholm\Psr7\Response;

class AuthMiddleware extends Authorise implements MiddlewareInterface
{
    public function __construct(string $secret, string $tokenKey)
    {
        parent::__construct($secret, $tokenKey);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $auth = $this->authorise($request);
         
        $request = $request->withAttribute('auth', $auth);
        $response = $handler->handle($request);
        return $response;  
    }
}