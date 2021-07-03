<?php declare (strict_types = 1);

namespace Corvus\Controller;

use Corvus\Helper\Money;
use Corvus\Entity\Product;
use Corvus\Repository\ProductRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\JsonResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class ProductController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Repository\ProductRepository
     */    
    private $productRepository;

    /**
     * @Inject
     * @var Psr\Log\LoggerInterface
     */    
    private $logger;

    /**
     * Controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function index(ServerRequestInterface $request) : JsonResponse
    {
        $products = $this->productRepository->findAll();
        $this->logger->warning('Hello My log');

        $resource = new Collection($products, function(Product $product) {
            return [
                'id'      => (int) $product->getId(),
                'name'   => $product->getName(),
                'links'   => [
                    [
                        'rel' => 'self',
                        'uri' => '/products/'.$product->getId().'/show',
                    ]
                ]
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

     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function show(ServerRequestInterface $request, array $args): JsonResponse
    {
        $product = $this->productRepository->find((int)$args['id']);

        $resource = new Item($product, function(Product $product) {
            return [
                'id'      => (int) $product->getId(),
                'title'   => $product->getName(),
                'links'   => [
                    [
                        'rel' => 'self',
                        'uri' => '/products/'.$product->getId().'/show',
                    ]
                ]
            ];
        });
        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }
}