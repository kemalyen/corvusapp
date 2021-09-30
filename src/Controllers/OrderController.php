<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Entities\Order;
use Corvus\Resources\OrderTransformer;
use Corvus\Repositories\OrderRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\JsonResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;

class OrderController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Services\OrderService
     */    
    private $orderService;

    public function index(ServerRequestInterface $request, array $args): JsonResponse
    {
        $orders = $this->orderService->getOrders();
        $resource = new Collection($orders, new OrderTransformer);
        $fractal = new Manager();
        $fractal->parseIncludes('order_lines');
        $data = $fractal->createData($resource)->toArray();

        return $this->view($data);        
    }

    public function show(ServerRequestInterface $request, array $args): JsonResponse
    {
        $order = $this->orderService->getOrder($args['id']);

        $resource = new Item($order, new OrderTransformer);
        
        $fractal = new Manager();
        $fractal->parseIncludes('order_lines');
        
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request

     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function create(ServerRequestInterface $request, array $args): JsonResponse
    {
        $body = $request->getParsedBody();
        $this->orderService->create($body);
        $data = ['message' =>'sucess'];
        return $this->view($data);
    }
}