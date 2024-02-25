<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

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
            'message' => 'Commentaires récupérés avec succès',
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
            $comment = Comment::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Commentaire créé avec succès',
                'comment' => $comment
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'status' => true,
            'message' => 'Commentaire trouvé avec succès',
            'user' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Commentaire mis à jour avec succès',
            'user' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Commentaire supprimé avec succès',
            'user' => $comment
        ]);
    }
}
