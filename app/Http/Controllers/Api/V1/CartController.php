<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartDestroyRequest;
use App\Http\Resources\CartResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\CartRepository;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @param CartRepository $cartRepository
     * @param CartService $cartService
     */
    public function __construct(private CartRepository $cartRepository, private CartService $cartService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cartItems = $this->cartRepository->getAll($request->user()->id);

        return ApiResponse::success(CartResource::collection($cartItems));
    }

    /**
     * @param CartStoreRequest $request
     * @return JsonResponse
     */
    public function store(CartStoreRequest $request): JsonResponse
    {
        $cartItem = $this->cartService->addToCart($request->user()->id, $request->product_id, $request->quantity);

        return ApiResponse::success(new CartResource($cartItem), 'Item added to cart successfully', 201);
    }

    /**
     * @param CartDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(CartDestroyRequest $request): JsonResponse
    {
        $this->cartService->removeFromCart($request->user()->id, $request->validated('product_id'));

        return ApiResponse::success('Item removed from cart successfully', 204);
    }
}
