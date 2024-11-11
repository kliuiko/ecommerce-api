<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\OrderStatus;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class PaymentController
{
    /**
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function paymentProcess(Request $request): Application|Redirector|RedirectResponse
    {
        $order = Order::query()
            ->findOrFail($request->query('order_id'));

        $paymentLink = route('orders.pay', [
            'order' => $order->id,
            'token' => $order->payment_token
        ]);

        return redirect($paymentLink);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentConfirmation(Order $order, Request $request): JsonResponse
    {
        if ($request->missing('token') || $order->payment_token !== $request->query('token') || $order->status !== OrderStatus::PENDING->value) {
            return ApiResponse::error('Invalid payment confirmation link', 404);
        }

        $order->status = OrderStatus::PAID->value;
        $order->payment_token = null;
        $order->save();

        return ApiResponse::success([], 'Order successfully paid');
    }
}
