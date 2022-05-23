<?php
namespace Corvus\Resources;

use Corvus\Entities\OrderedProduct;
use League\Fractal;

class OrderLineTransformer extends Fractal\TransformerAbstract
{
	public function transform(OrderedProduct $orderedProduct): array
	{
        return [
            'id'      => (int) $orderedProduct->getId(),
            'sku'   => $orderedProduct->getSku(),
            'description'   => $orderedProduct->getDescription(),
            'quantity'   => $orderedProduct->getQuantity(),
            'unit_price'   => $orderedProduct->getUnitPrice(),
        ];
	}
}