<?php

namespace App\Application\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function query()
    {
        return Comment::query();
    }

    public function findByProductId(int $productId)
    {
        return $this->query()
            ->where('product_id', $productId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $id)
    {
        return $this->query()->with('user', 'product')->find($id);
    }

    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function update(int $id, array $data)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($data);

        return $comment->load('user');
    }

    public function delete(int $id): void
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }
}
