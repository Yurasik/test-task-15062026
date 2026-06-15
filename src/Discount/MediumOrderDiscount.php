<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

class MediumOrderDiscount implements DiscountRuleInterface
{
    public function getDiscount(Order $order): float
    {
        return $order->amount > 500 ? 0.05 : 0.0;
    }
}
