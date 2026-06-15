<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

interface DiscountRuleInterface
{
    public function getDiscount(Order $order): float;
}
