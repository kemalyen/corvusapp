<?php declare (strict_types = 1);

namespace Corvus\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
 
class IndexController extends BaseController
{
    /**
     * @Inject
     * @var \Twig\Environment
     */ 
    protected $template;

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('index.html', ['name' => 'Fabien']);
    }
}