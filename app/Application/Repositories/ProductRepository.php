<?php

namespace App\Application\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function query()
    {
        return Product::query();
    }

    public function findById(int $id)
    {
        return $this->query()
            ->with(['category', 'comments', 'orderItems'])
            ->find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);

        return $product;
    }

    public function delete(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
