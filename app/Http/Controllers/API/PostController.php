<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'status' => true,
            'message' => 'Posts récupérés avec succès',
            'users' => $posts
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
                'tags' => 'required|string',
                'user_id' => 'required|exists:users,id'
            ]);

            $post = Post::create($validatedData);

            return response()->json($post, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = Post::find($post->id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try {
            $post = Post::findOrFail($post->id);

            $validatedData = $request->validate([
                'content' => 'required|string',
                'image' => 'nullable|image',
                'tags' => 'required|string',
            ]);

            $post->update($validatedData);

            return response()->json($post);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = Post::find($post->id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
