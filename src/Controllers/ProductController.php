<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Resources\ProductTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Container\ContainerInterface;
use Corvus\Services\ProductService;

class ProductController extends BaseController
{
    /**
     * @Inject
     * @var Corvus\Services\ProductService
     */
    private $productService;
 
    /**
     * List products
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return JsonResponse
     */
    public function index(ServerRequestInterface $request, array $args): JsonResponse
    {
        $products = $this->productService->getProducts();
        $resource = new Collection($products, new ProductTransformer);
        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }

    /**
     * SHow single product
     *
     * @param ServerRequestInterface $request
     * @param array $args
     * @return JsonResponse
     */
    public function show(ServerRequestInterface $request, array $args): JsonResponse
    {
        $product = $this->productService->getProduct((int) $args['id']);
        if (empty($product)) return $this->view('No products found', 404); 
        $resource = new Item($product, new ProductTransformer);
        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }
}