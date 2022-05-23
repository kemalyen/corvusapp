<?php
namespace Corvus\Resources;

use Corvus\Entities\Order;
use League\Fractal;

class OrderTransformer extends Fractal\TransformerAbstract
{
    protected array $availableIncludes = [
        'ordered_products'
    ]; 

	public function transform(Order $order): array
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

    public function includeOrderedProducts(Order $order)
    {
        $order_lines = $order->getOrderedProducts();
        return $this->collection($order_lines, new OrderLineTransformer());
    }
}