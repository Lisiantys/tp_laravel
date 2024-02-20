<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'pseudo' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'image' => 'nullable|image',
                'role_id' => 'required|exists:roles,id'
            ]);

            $validatedData["password"] = Hash::make($validatedData["password"]);

            $user = User::create($validatedData);

            return response()->json($user, 201);
        } catch (ValidationException $e) {

            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::find($user->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $user = User::findOrFail($user->id);

            $validatedData = $request->validate([
                'pseudo' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'sometimes|required|string|min:8',
                'image' => 'nullable|image',
                'role_id' => 'required|exists:roles,id'
            ]);

            if ($request->has('password')) {
                $validatedData['password'] = Hash::make($request->password);
            }

            $user->update($validatedData);

            return response()->json($user);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid data provided'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
