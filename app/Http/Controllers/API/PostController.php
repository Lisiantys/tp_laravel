<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image',
            'tags' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $post = Post::create($validatedData);

        return response()->json($post, 201);
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
        $post = Post::findOrFail($post->id);

        $validatedData = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image',
            'tags' => 'required|string',
        ]);

        $post->update($validatedData);

        return response()->json($post);
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
