<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository
{
    /**
     * @param int $userId
     * @param array $sort
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(int $userId, array $sort, array $filters): LengthAwarePaginator
    {
        $query = Order::query()
            ->where('user_id', $userId);

        foreach ($filters as $filterKey => $filterValue) {
            if ($filterValue) {
                $query->where($filterKey, $filterValue);
            }
        }

        return $query->orderBy($sort['sort_by'], $sort['sort_order'])
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return Order
     */
    public function getById(int $id): Order
    {
        return Order::query()
            ->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Order
     */
    public function store(array $data): Order
    {
        return Order::query()
            ->create($data);
    }
}
