<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;


class IndexController extends BaseController
{
   public function index(ServerRequestInterface $request): JsonResponse
    {
        $data = ['name' =>'Kemal'];
        return $this->view($data);
    }
}