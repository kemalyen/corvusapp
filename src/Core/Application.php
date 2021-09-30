<?php

namespace Corvus\Core;

class Application
{
    public $router;
    protected $response;

    public function router(\League\Route\Router $router){
        $this->router = $router;
    }

    public function process(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->response = $this->router->dispatch($request);   
    }

    public function run()
    {
        (new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($this->response);        
    }
}