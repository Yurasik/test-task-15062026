<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

class HighOrderDiscount implements DiscountRuleInterface
{
    public function __construct(
        private float $threshold = 1000.0,
        private float $rate      = 0.10,
    ) {}

    public function getDiscount(Order $order): float
    {
        return $order->amount > $this->threshold ? $this->rate : 0.0;
    }
}
