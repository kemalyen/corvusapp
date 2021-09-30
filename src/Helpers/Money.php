<?php declare(strict_types=1);

namespace Corvus\Helper;
 

class Money  
{
    /**
     * {@inheritdoc}
     */
    public function format_currency($num = 2)
    {
        $n = rand(1, 10);
        return $n * $num;
    }
}