<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Http\Responses\ApiResponse;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param OrderRepository $orderRepository
     * @param OrderService $orderService
     * @param CartService $cartService
     */
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderService    $orderService,
        private readonly CartService     $cartService
    )
    {
    }

    /**
     * @param OrderIndexRequest $request
     * @return JsonResponse
     */
    public function index(OrderIndexRequest $request): JsonResponse
    {
        $userId = $request->user()->id;

        $filters = [
            'status' => $request->get('status')
        ];

        $sort = [
            'sort_by' => $request->get('sort_by', 'created_at'),
            'sort_order' => $request->get('sort_order', 'desc')
        ];

        $orders = $this->orderRepository->getAll($userId, $sort, $filters);

        return ApiResponse::success(OrderResource::collection($orders));
    }

    /**
     * @param OrderStoreRequest $request
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $totalAmount = $this->cartService->calculateTotalAmount($userId);

        if ($totalAmount <= 0) {
            return ApiResponse::error('Your cart is empty. Add items to proceed with checkout.');
        }

        $paymentToken = $this->orderService->generatePaymentToken();

        $order = $this->orderRepository->store([
            'user_id' => $userId,
            'payment_method_id' => $request->validated('payment_method_id'),
            'total_amount' => $totalAmount,
            'payment_token' => $paymentToken
        ]);

        $paymentLink = $this->orderService->generatePaymentLink($order);
        $this->cartService->clearCart($userId);

        return ApiResponse::success(['payment_link' => $paymentLink], 'Order successfully created');
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        $order = $this->orderRepository->getById($order->id);

        return ApiResponse::success(new OrderResource($order), 'Order received successfully');
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return void
     */
    public function update(Request $request, Order $order)
    {
    }

    /**
     * @param Order $order
     * @return void
     */
    public function destroy(Order $order)
    {
    }
}
