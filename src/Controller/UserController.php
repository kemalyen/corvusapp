<?php declare (strict_types = 1);

namespace Corvus\Controller;

use Corvus\Core\Jwt;
use Corvus\Helper\Money;
use Corvus\Entity\Product;
use Corvus\Repository\ProductRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Corvus\Entity\User;
use Symfony\Component\Validator\Validation;


class UserController extends BaseController
{
    protected $money;

    /**
     * @Inject
     * @var Corvus\Repository\UserRepository
     */    
    private $userRepository;
 
 
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
 
        $user = $this->userRepository->getUserByEmail($payload['email']);
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
        $user = $this->userRepository->getUser($body['email'], $body['password']);
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
    public function create(ServerRequestInterface $request) : JsonResponse
    {
        $body = $request->getParsedBody();
        $user = new User;
        $user->setEmail($body['email']);
        $user->setPassword(md5($body['password']));

        $validator = Validation::createValidatorBuilder()
                            ->enableAnnotationMapping()
                            ->getValidator();
    
        $violations = $validator->validate($user);
  
        if (0 !== count($violations)) {
            // there are errors, now you can show them
            foreach ($violations as $violation) {
                echo $violation->getMessage().'<br>';
            }
        }         

        $this->userRepository->createUser($user);
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

}    