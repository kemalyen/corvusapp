<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Helper\Money;
use Corvus\Entity\Product;
use Corvus\Repository\ProductRepository;
use Corvus\Resources\ProductTransformer;
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
     * @var Corvus\Services\ProductService
     */    
    private $productService;

    public function index(ServerRequestInterface $request, array $args): JsonResponse
    {
        $products = $this->productService->getProducts();
        $resource = new Collection($products, new ProductTransformer);
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
        $product = $this->productService->getProduct((int)$args['id']);
        $resource = new Item($product, new ProductTransformer);
        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);   
    }
}