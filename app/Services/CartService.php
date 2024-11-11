<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\CartRepository;

class CartService
{
    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(protected CartRepository $cartRepository)
    {
    }

    /**
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return Cart
     */
    public function addToCart(int $userId, int $productId, int $quantity): Cart
    {
        $cartItem = $this->cartRepository->find($userId, $productId);

        if ($cartItem) {

            $newQuantity = $cartItem->quantity + $quantity;
            $this->cartRepository->updateQuantity($cartItem, $newQuantity);

        } else {

            $cartItem = $this->cartRepository->store([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);

        }

        return $cartItem;
    }

    /**
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function removeFromCart(int $userId, int $productId): bool
    {
        $cartItem = $this->cartRepository->find($userId, $productId);

        if ($cartItem) {
            return $this->cartRepository->delete($cartItem->id);
        }

        return false;
    }

    /**
     * @param int $userId
     * @return void
     */
    public function clearCart(int $userId): void
    {
        $this->cartRepository->deleteAll($userId);
    }

    /**
     * @param int $userId
     * @return int
     */
    public function calculateTotalAmount(int $userId): int
    {
        $totalPrice = 0;
        $cartItems = $this->cartRepository->getAll($userId);

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }

        return $totalPrice;
    }
}
