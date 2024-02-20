<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();

        return response()->json([
            'status' => true,
            'message' => 'Posts récupérés avec succès',
            'users' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'content' => 'required|string',
                'image' => 'nullable|image',
                'tags' => 'nullable|string',
                'post_id' => 'required|exists:posts,id',
                'user_id' => 'required|exists:users,id'
            ]);

            $comment = Comment::create($validatedData);

            return response()->json($comment, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment = Comment::find($comment->id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            $comment = Comment::findOrFail($comment->id);

            $validatedData = $request->validate([
                'content' => 'required|string',
                'image' => 'nullable|image',
                'tags' => 'nullable|string',
            ]);

            $comment->update($validatedData);

            return response()->json($comment);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::find($comment->id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
