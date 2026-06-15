<?php

declare(strict_types=1);

namespace App\Payment;

use App\Order;

interface PaymentInterface
{
    public function process(Order $order): string;
}
