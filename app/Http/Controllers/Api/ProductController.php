<?php

namespace App\Http\Controllers\Api;

use App\Application\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        readonly ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'min_price', 'max_price', 'sort']);
        $perPage = (int) $request->get('per_page', 10);
        $products = $this->productService->getProducts($filters, $perPage);

        return ProductResource::collection($products);
    }

    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductDetailResource($product);
    }


    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return new ProductDetailResource($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return new ProductDetailResource($product);
    }

    public function destroy(int $id)
    {
        $this->productService->deleteProduct($id);

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
