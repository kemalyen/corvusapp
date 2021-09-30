<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Entity\Product;
use Corvus\Resources\ProductTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

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
        $resource = new Item($product, new ProductTransformer);
        $fractal = new Manager();
        $data = $fractal->createData($resource)->toArray();
        return $this->view($data);
    }
}