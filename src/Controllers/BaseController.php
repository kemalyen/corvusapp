<?php declare (strict_types = 1);

namespace Corvus\Controllers;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;

class BaseController
{
    public function view(string|array $data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status, ['Content-Type' => ['application/hal+json']]);
    }

    public function render(string $filename, array $data): HtmlResponse
    {
        $viewData = $this->template->render($filename, $data);
        return new HtmlResponse($viewData, 200);
    }
}