<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

class HighOrderDiscount implements DiscountRuleInterface
{
    public function getDiscount(Order $order): float
    {
        return $order->amount > 1000 ? 0.10 : 0.0;
    }
}
