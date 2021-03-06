<?php declare (strict_types = 1);

namespace Corvus\Controller;

use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;

class BaseController
{
    public function view(array $data): JsonResponse
    {
        return new JsonResponse($data, 200, ['Content-Type' => ['application/hal+json']]);
    }
    
    public function render(string $filename, array $data): HtmlResponse
    {
        $viewData = $this->template->render($filename, $data);
        return new HtmlResponse($viewData, 200);
    }    

}
