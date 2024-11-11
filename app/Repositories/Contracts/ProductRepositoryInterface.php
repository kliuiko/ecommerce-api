<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAll(array $sort): mixed;

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed;

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed;

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id): mixed;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
