<?php

namespace App\Http\Controllers\Api;

use App\Application\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(readonly ProductService $productService
    )
    {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'min_price', 'max_price', 'sort']);
        $perPage = (int) $request->get('per_page', 10);
        $products = $this->productService->getProducts($filters, $perPage);

        return ProductResource::collection($products);
    }
    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
