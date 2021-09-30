<?php
namespace Corvus\Resources;

use Corvus\Entities\Order;
use Corvus\Entities\OrderLine;
use League\Fractal;

class OrderLineTransformer extends Fractal\TransformerAbstract
{
	public function transform(OrderLine $order)
	{
        return [
            'id'      => (int) $order->getId(),
            'sku'   => $order->getSku(),
            'title'   => $order->getTitle(),
            'quantity'   => $order->getQuantity(),
            'amount'   => $order->getAmount(),
            
        ];
	}
}