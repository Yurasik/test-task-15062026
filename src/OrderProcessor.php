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
        private OrderFormatter     $formatter,
    ) {}

    public function process(Order $order): string
    {
        try {
            $payment = $this->resolvePayment($order->paymentMethod);
        } catch (\InvalidArgumentException $e) {
            $this->logger->log("Order #{$order->id} failed: {$e->getMessage()}");

            return implode(PHP_EOL, [
                "Order #{$order->id}",
                "Error: {$e->getMessage()}",
            ]);
        }

        $discount = $this->discountCalculator->calculate($order);

        $payment->process($order);
        $this->logger->log("Order #{$order->id} processed");

        return $this->formatter->format($order, $discount, $this->paymentLabel($order->paymentMethod));
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
