<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Corvus\Helper;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;


class IndexController extends BaseController
{

    private $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function test(ServerRequestInterface $request, array $arg): JsonResponse
    {
        $this->helper->sayHello();
        $data = ['test time' => time()];
        return $this->view($data);
    }    

   public function index(ServerRequestInterface $request): JsonResponse
    {
        $data = ['time' => time()];
        return $this->view($data);
    }
}