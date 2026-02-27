<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Bluetooth over-ear headphones with noise cancellation.',
                'price' => 129.99,
                'category' => 'Electronics',
                'image' => 'products/headphones.jpg',
            ],
            [
                'name' => 'Laravel in Practice',
                'description' => 'Practical handbook for building APIs with Laravel.',
                'price' => 39.90,
                'category' => 'Books',
                'image' => 'products/laravel-book.jpg',
            ],
            [
                'name' => 'Standing Desk Lamp',
                'description' => 'LED lamp with adjustable brightness and warm mode.',
                'price' => 54.50,
                'category' => 'Home',
                'image' => 'products/lamp.jpg',
            ],
            [
                'name' => 'Yoga Mat Pro',
                'description' => 'Non-slip yoga mat, 6mm, for home workouts.',
                'price' => 27.00,
                'category' => 'Sports',
                'image' => 'products/yoga-mat.jpg',
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();

            if (!$category) {
                continue;
            }

            Product::firstOrCreate(
                ['name' => $item['name']],
                [
                    'slug' => Str::slug($item['name']),
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'category_id' => $category->id,
                    'image' => $item['image'],
                ]
            );
        }
    }
}
