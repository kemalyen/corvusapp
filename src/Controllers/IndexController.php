<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;


class IndexController extends BaseController
{
   public function index(ServerRequestInterface $request): JsonResponse
    {
        $data = ['time' => time()];
        return $this->view($data);
    }
}