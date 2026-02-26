<?php

namespace App\Http\Controllers\Api;

use App\Application\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;

class CommentController extends Controller
{
    public function __construct(
        readonly CommentService $commentService
    ) {}

    public function index(int $productId)
    {
        $comments = $this->commentService->getCommentsByProduct($productId);

        return CommentResource::collection($comments);
    }

    public function show(int $id)
    {
        $comment = $this->commentService->getCommentById($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return new CommentResource($comment);
    }

    public function store(StoreCommentRequest $request, int $productId)
    {
        $comment = $this->commentService->createComment($productId, auth()->id(), $request->validated());

        return new CommentResource($comment);
    }

    public function update(UpdateCommentRequest $request, int $id)
    {
        $comment = $this->commentService->updateComment(
            $id,
            auth()->id(),
            $request->validated()
        );

        return new CommentResource($comment);
    }

    public function destroy(int $id)
    {
        $this->commentService->deleteComment($id, auth()->id());

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}
