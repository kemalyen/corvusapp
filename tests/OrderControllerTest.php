<?php

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class OrderControllerTest extends TestCase
{
    protected static  $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost'
        ]);
    }
 
    public function test_get_orders()
    {
        $client = self::$client;
        $response = $client->get('/orders/list');
        $array = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('data', $array);
    }

    public function test_get_one_order()
    {
        $client = self::$client;
        $response = $client->get('/orders/1/show');
        $array = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('data', $array);
    }

}
