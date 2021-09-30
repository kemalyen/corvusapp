<?php
namespace Corvus\Resources;

use Corvus\Entities\Order;
use Corvus\Entities\OrderLine;
use League\Fractal;

class OrderTransformer extends Fractal\TransformerAbstract
{

    protected $availableIncludes = [
        'order_lines'
    ];

	public function transform(Order $order)
	{
        return [
            'id'      => (int) $order->getId(),
            'order_number'   => $order->getOrderNumber(),
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/orders/'.$order->getId().'/show',
                ]
            ]
        ];
	}

    public function includeOrderLines(Order $order)
    {
        $order_lines = $order->GetOrderLines();

        return $this->Collection($order_lines, new OrderLineTransformer);
    }
}