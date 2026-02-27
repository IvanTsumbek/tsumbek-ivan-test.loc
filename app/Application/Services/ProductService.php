<?php

namespace App\Application\Services;

use App\Application\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        readonly ProductRepository $repo
    ) {}

    public function getProducts(array $filters = [], int $perPage = 10)
    {
        $query = $this->repo->query()->with('category');

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'popular') {
                $query->withCount('orderItems')
                    ->orderBy('order_items_count', 'desc');
            } elseif ($filters['sort'] === 'price' || $filters['sort'] === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($filters['sort'] === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }

        return $query->paginate($perPage);
    }

    public function getProductById(int $id)
    {
        return $this->repo->findById($id);
    }

    public function createProduct(array $data)
    {
        $product = $this->repo->create($data);

        return $product->load('category');
    }

    public function updateProduct(int $id, array $data)
    {
        $product = $this->repo->update($id, $data);

        return $product->load('category');
    }

    public function deleteProduct(int $id): void
    {
        $this->repo->delete($id);
    }
}
