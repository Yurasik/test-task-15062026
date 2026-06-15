<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

class MediumOrderDiscount implements DiscountRuleInterface
{
    public function __construct(
        private float $threshold = 500.0,
        private float $rate      = 0.05,
    ) {}

    public function getDiscount(Order $order): float
    {
        return $order->amount > $this->threshold ? $this->rate : 0.0;
    }
}
