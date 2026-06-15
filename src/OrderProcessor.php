<?php

declare(strict_types=1);

namespace App;

use App\Discount\DiscountCalculator;
use App\Logger\LoggerInterface;
use App\Payment\PaymentInterface;

class OrderProcessor
{
    /** @param array<string, PaymentInterface> $payments */
    public function __construct(
        private array              $payments,
        private DiscountCalculator $discountCalculator,
        private LoggerInterface    $logger,
    ) {}

    public function process(Order $order): string
    {
        $payment  = $this->resolvePayment($order->paymentMethod);
        $discount = $this->discountCalculator->calculate($order);
        $finalAmount = $order->amount - $discount;

        $payment->process($order);
        $this->logger->log("Order #{$order->id} processed");

        return implode(PHP_EOL, [
            "Order #{$order->id}",
            "Amount: {$order->amount}",
            "Discount: {$discount}",
            "Final amount: {$finalAmount}",
            "Payment: {$this->paymentLabel($order->paymentMethod)}",
        ]);
    }

    private function resolvePayment(string $method): PaymentInterface
    {
        if (!isset($this->payments[$method])) {
            throw new \InvalidArgumentException("Unknown payment method: {$method}");
        }

        return $this->payments[$method];
    }

    private function paymentLabel(string $method): string
    {
        return match ($method) {
            'card'   => 'Card',
            'paypal' => 'PayPal',
            'cash'   => 'Cash',
            default  => ucfirst($method),
        };
    }
}
