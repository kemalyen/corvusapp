<?php

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DefaultControllerTest extends TestCase
{
    protected static  $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost'
        ]);
    }

    public function testIndexController()
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $controller = new Corvus\Controllers\IndexController();
        $response = $controller->index($serverRequest);
        $this->assertArrayHasKey('time', $response->getPayload());
    }

    public function test_visit_index()
    {
        $client = self::$client;
        $response = $client->get('/');
        $array = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('time', $array);
    }

}
