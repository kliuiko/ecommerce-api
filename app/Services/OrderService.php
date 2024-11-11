<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;

/**
 *
 */
class OrderService
{
    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    /**
     * @return string
     * @throws \Random\RandomException
     */
    public function generatePaymentToken(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * @param Order $order
     * @return array|string
     */
    public function generatePaymentLink(Order $order): array|string
    {
        $paymentLinkTemplate = $order->paymentMethod->payment_url_template;

        return str_replace(
            ['{order_id}', '{amount}'],
            [$order->id, $order->total_amount],
            $paymentLinkTemplate
        );
    }
}
