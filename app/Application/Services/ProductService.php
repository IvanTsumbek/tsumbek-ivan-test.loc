<?php

namespace App\Application\Services;

use App\Application\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        readonly ProductRepository $repo
    )
    {
    }

    public function getProducts(array $filters = [], int $perPage = 10)
    {
        $query = $this->repo->query();

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        if (!empty($filters['sort']) && $filters['sort'] === 'popular') {
            $query->withCount('orderItems')
                ->orderBy('order_items_count', 'desc');
        }

        return $query->paginate($perPage);
    }
}
