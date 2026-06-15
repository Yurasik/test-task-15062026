<?php

declare(strict_types=1);

namespace App\Discount;

use App\Order;

class DiscountCalculator
{
    /** @param DiscountRuleInterface[] $rules */
    public function __construct(private array $rules) {}

    public function calculate(Order $order): float
    {
        $best = 0.0;

        foreach ($this->rules as $rule) {
            $rate = $rule->getDiscount($order);
            if ($rate > $best) {
                $best = $rate;
            }
        }

        return round($order->amount * $best, 2);
    }
}
