<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Order.php';
require_once __DIR__ . '/src/Payment/PaymentInterface.php';
require_once __DIR__ . '/src/Payment/CardPayment.php';
require_once __DIR__ . '/src/Payment/PaypalPayment.php';
require_once __DIR__ . '/src/Payment/CashPayment.php';
require_once __DIR__ . '/src/Discount/DiscountRuleInterface.php';
require_once __DIR__ . '/src/Discount/HighOrderDiscount.php';
require_once __DIR__ . '/src/Discount/MediumOrderDiscount.php';
require_once __DIR__ . '/src/Discount/DiscountCalculator.php';
require_once __DIR__ . '/src/Logger/LoggerInterface.php';
require_once __DIR__ . '/src/Logger/FileLogger.php';
require_once __DIR__ . '/src/OrderProcessor.php';

use App\Discount\DiscountCalculator;
use App\Discount\HighOrderDiscount;
use App\Discount\MediumOrderDiscount;
use App\Logger\FileLogger;
use App\Order;
use App\OrderProcessor;
use App\Payment\CardPayment;
use App\Payment\CashPayment;
use App\Payment\PaypalPayment;

$orders = [
    [
        'id'             => 1,
        'user'           => 'John',
        'amount'         => 500,
        'payment_method' => 'card',
    ],
    [
        'id'             => 2,
        'user'           => 'Mike',
        'amount'         => 1200,
        'payment_method' => 'paypal',
    ],
    [
        'id'             => 3,
        'user'           => 'Anna',
        'amount'         => 800,
        'payment_method' => 'cash',
    ],
];

$processor = new OrderProcessor(
    payments: [
        'card'   => new CardPayment(),
        'paypal' => new PaypalPayment(),
        'cash'   => new CashPayment(),
    ],
    discountCalculator: new DiscountCalculator([
        new HighOrderDiscount(),
        new MediumOrderDiscount(),
    ]),
    logger: new FileLogger(__DIR__ . '/logs/orders.log'),
);

foreach ($orders as $data) {
    $order = new Order(
        id:            $data['id'],
        user:          $data['user'],
        amount:        (float) $data['amount'],
        paymentMethod: $data['payment_method'],
    );

    echo $processor->process($order) . PHP_EOL;
    echo str_repeat('-', 30) . PHP_EOL;
}
