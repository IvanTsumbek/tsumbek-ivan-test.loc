<?php

namespace App\Application\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function query()
    {
        return Product::query();
    }

    public function findById($id)
    {
        return Product::find($id);
    }
}