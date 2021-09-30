<?php
namespace Corvus\Resources;

use Corvus\Entities\Product;
use League\Fractal;

class ProductTransformer extends Fractal\TransformerAbstract
{
	public function transform(Product $product)
	{
        return [
            'id'      => (int) $product->getId(),
            'sku'   => $product->getSku(),
            'title'   => $product->getTitle(),
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/products/'.$product->getId().'/show',
                ]
            ]
        ];
	}

}