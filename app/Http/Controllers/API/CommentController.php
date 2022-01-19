<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use Illuminate\Http\Request;
use App\Http\Requests\SendCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function getComments(Request $request)
    {
        $comments = Comment::with(['children', 'children.children'])->where('mother_id', 0)->latest()->paginate(10);

        return new CommentCollection($comments);
    }

    public function sendComment(SendCommentRequest $request)
    {
        Comment::create($request->all());

        return response()->json(['data' => ['Success'], 'message' => ["Comment sent successfully."]], 200);
    }
}
