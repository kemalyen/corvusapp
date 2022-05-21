<?php declare(strict_types=1);

namespace Corvus\Middlewares;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use PsrJwt\Helper\Request;
use Laminas\Diactoros\Response\JsonResponse;

class AuthPayloadMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $helper = new Request();
        $payload = $helper->getTokenPayload($request, 'auth');
        if ($payload){
            $request = $request->withAttribute('payload', $payload);
        }else{
            return new JsonResponse('Auth failed!', 403, ['Content-Type' => ['application/hal+json']]);
        }
        $response = $handler->handle($request);
        return $response;
    }
}