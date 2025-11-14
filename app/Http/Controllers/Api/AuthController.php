<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Requests\UpdateUserAsManagerRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AuthController extends Controller
{
    use AuthorizesRequests;

    public function login(Request $request)
    {
        // Validate request
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }
        
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'rederict_page'=>'dashboard'
        ], 200);
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rule' => ['nullable', 'string', 'in:user,author,manager'],
            'est' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rule' => $request->rule ?? 'user', 
            'est' => $request->est,
        ]);
        Auth::login($user);
        $token = $user->createToken('admin-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // public function update(UpdateUserAsManagerRequest $request, User $user)
    // {
    //     $this->authorize('updateAsManager', $user);
    //     $validated = $request->validated();
    //     $user->update($validated);
    //     return response()->json($user);
    // }

    public function updateProfile(UpdateUserRequest $request)
    {
        $user = $request->user();
        $validated = $request->safe()->only(['name', 'email']);
        $user->update($validated);
        return response()->json([
            'status' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}