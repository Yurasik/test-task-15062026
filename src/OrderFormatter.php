<?php

declare(strict_types=1);

namespace App;

class OrderFormatter
{
    public function format(Order $order, float $discount, string $paymentLabel): string
    {
        $finalAmount = $order->amount - $discount;

        return implode(PHP_EOL, [
            "Order #{$order->id}",
            "Amount: {$order->amount}",
            "Discount: " . ($discount > 0 ? $discount : 'none'),
            "Final amount: {$finalAmount}",
            "Payment: {$paymentLabel}",
        ]);
    }
}
