<?php

namespace App\Application\Services;

use App\Application\Repositories\CommentRepository;

class CommentService
{
    public function __construct(
        readonly CommentRepository $repo
    ) {}

    public function getCommentsByProduct(int $productId)
    {
        return $this->repo->findByProductId($productId);
    }

    public function getCommentById(int $id)
    {
        return $this->repo->findById($id);
    }

    public function createComment(int $productId, int $userId, array $data)
    {
        $data['product_id'] = $productId;
        $data['user_id'] = $userId;

        return $this->repo->create($data)->load('user');
    }

    public function updateComment(int $id, int $userId, array $data)
    {
        $comment = $this->repo->findById($id);

        if (!$comment) {
            throw new \Exception('Comment not found');
        }

        if ($comment->user_id !== $userId && !auth()->user()->isAdmin()) {
            throw new \Exception('Forbidden');
        }

        return $this->repo->update($id, $data);
    }

    public function deleteComment(int $id, int $userId): void
    {
        $comment = $this->repo->findById($id);

        if (!$comment) {
            throw new \Exception('Comment not found');
        }

        if ($comment->user_id !== $userId && !auth()->user()->isAdmin()) {
            throw new \Exception('Forbidden');
        }

        $this->repo->delete($id);
    }
}
