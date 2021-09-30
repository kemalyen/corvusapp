<?php declare(strict_types=1);

namespace Corvus\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use PsrJwt\Helper\Request;

class AuthPayloadMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $helper = new Request();
        $payload = $helper->getTokenPayload($request, 'jwt');
        if ($payload){
            $request = $request->withAttribute('payload', $payload);
        }
        $response = $handler->handle($request);
        return $response;
    }
}