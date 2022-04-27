<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Core\Jwt;
use Corvus\Entities\User;
use Laminas\Diactoros\Response\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Services\UserService
     */
    private $userService;

    /**
     * @var Psr\Container\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function me(ServerRequestInterface $request): ResponseInterface
    {
        $auth = $request->getAttribute('auth');

        if (!$auth->getMessage()) {
            throw new Exception("Unauthorized request", 403);
        }//

        $payload = $request->getAttribute('payload');

        $user = $this->userService->getUserByEmail($payload['email']);
        $resource = new Item($user, function (User $user) {
            return [
                'id' => (int) $user->getId(),
                'email' => $user->getEmail(),
            ];
        });

        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();

        return $this->view($data);
    }

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function get_token(ServerRequestInterface $request): JsonResponse
    {
        $body = $request->getParsedBody();
        $user = $this->userService->getUser($body['email'], $body['password']);
        $token = Jwt::create($user->getEmail(), $this->container->get('JWT_SECRET'));
        return $this->view(['token' => $token->getToken()]);
    }

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function register(ServerRequestInterface $request): JsonResponse
    {
        $body = $request->getParsedBody();
        $this->userService->create($body);
        $data = [];
        return $this->view($data);
    }
}