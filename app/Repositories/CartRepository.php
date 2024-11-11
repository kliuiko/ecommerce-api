<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CartRepository
{
    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getAll(int $userId): LengthAwarePaginator
    {
        return Cart::query()
            ->where('user_id', $userId)
            ->paginate(20);
    }

    /**
     * @param int $userId
     * @return void
     */
    public function deleteAll(int $userId): void
    {
        Cart::query()
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @param int $userId
     * @param int $productId
     * @return Cart|null
     */
    public function find(int $userId, int $productId): ?Cart
    {
        return Cart::query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * @param array $data
     * @return Cart
     */
    public function store(array $data): Cart
    {
        return Cart::query()
            ->create($data);
    }

    /**
     * @param int $cartItemId
     * @return mixed
     */
    public function delete(int $cartItemId)
    {
        return Cart::query()
            ->where('id', $cartItemId)
            ->delete();
    }

    /**
     * @param Cart $cartItem
     * @param int $quantity
     * @return bool
     */
    public function updateQuantity(Cart $cartItem, int $quantity): bool
    {
        $cartItem->quantity = $quantity;

        return $cartItem->save();
    }
}
