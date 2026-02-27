<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();
        $products = Product::query()->take(2)->get();

        if (!$user || !$admin || $products->isEmpty()) {
            return;
        }

        Comment::firstOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $products[0]->id,
                'text' => 'Great product. Good value for the price.',
            ]
        );

        Comment::firstOrCreate(
            [
                'user_id' => $admin->id,
                'product_id' => $products[1]->id,
                'text' => 'Quality looks solid, approved for catalog.',
            ]
        );
    }
}
