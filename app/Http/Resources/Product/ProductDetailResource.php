<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'category' => $this->whenLoaded('category'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'order_count' => $this->whenLoaded('orderItems', fn() => $this->orderItems->count()),
        ];
    }
}