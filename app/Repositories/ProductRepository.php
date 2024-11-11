<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @param array $sort
     * @return LengthAwarePaginator
     */
    public function getAll(array $sort): LengthAwarePaginator
    {
        return Product::query()
            ->orderBy($sort['sort_by'], $sort['sort_order'])
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getById(int $id): Product
    {
        return Product::query()
            ->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Product
     */
    public function store(array $data): Product
    {
        return Product::query()
            ->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update(array $data, int $id): int
    {
        return Product::query()
            ->where('id', $id)
            ->update($data);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Product::destroy($id);
    }
}
