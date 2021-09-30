<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Core\Jwt;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Corvus\Entities\User;
use Symfony\Component\Validator\Validation;


class UserController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Services\UserService
     */    
    private $userService;

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
        $payload = $request->getAttribute('payload');
 
        $user = $this->userService->getUserByEmail($payload['email']);
        $resource = new Item($user, function(User $user) {
            return [
                'id'      => (int) $user->getId(),
                'email'   => $user->getEmail() 
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
    public function get_token(ServerRequestInterface $request) : JsonResponse
    {
        $body = $request->getParsedBody();
        $user = $this->userService->getUser($body['email'], $body['password']);
        $token = Jwt::create($user->getEmail());
        return $this->view(['token' => $token->getToken()]);
    }

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function register(ServerRequestInterface $request) : JsonResponse
    {
        $body = $request->getParsedBody();
        $this->userService->create($body);
        $data = [];
        return $this->view($data);    
    }
}    