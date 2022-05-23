<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Resources\OrderTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;

class OrderController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Services\OrderService
     */
    private $orderService;

    /**
     * @Inject
     * @var Psr\Log\LoggerInterface
    */    
    private $logger;
    /**
     * List Orders
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return JsonResponse
     */
    public function index(ServerRequestInterface $request, array $args): JsonResponse
    {
        $orders = $this->orderService->getOrders();
        $fractal = new Manager();
        $resource = new Collection($orders, new OrderTransformer);
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }

    /**
     * Show single order
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return JsonResponse
     */
    public function show(ServerRequestInterface $request, array $args): JsonResponse
    {
        $order = $this->orderService->getOrder($args['id']);
        $resource = new Item($order, new OrderTransformer);
        $fractal = new Manager();
        $fractal->parseIncludes('ordered_products');
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }

    /**
     * Create an order
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return JsonResponse
     */
    public function create(ServerRequestInterface $request, array $args): JsonResponse
    {
        $payload = $request->getAttribute('payload');
        $this->logger->info('This is a an order inserted at '. time());
        $body = $request->getParsedBody();
        $this->orderService->create($body);
        $data = ['message' => 'sucess'];
        return $this->view($data);
    }
}