<?php

declare(strict_types=1);

namespace App;

class Order
{
    public function __construct(
        public readonly int    $id,
        public readonly string $user,
        public readonly float  $amount,
        public readonly string $paymentMethod,
    ) {}
}
