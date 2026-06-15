<?php

declare(strict_types=1);

namespace App\Payment;

use App\Order;

class PaypalPayment implements PaymentInterface
{
    public function process(Order $order): string
    {
        return "Order #{$order->id} paid via PayPal";
    }
}
