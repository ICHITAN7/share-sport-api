<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource. (Admin Only)
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $user = User::latest()->paginate(20);
        return response()->json([
            'message'=>'index',
            'data'=>$user
        ]);
    }

    /**
     * Update the specified resource in storage. (Admin Only)
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:150',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:180',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => ['sometimes', Rule::in(['admin', 'writer', 'viewer'])],
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        if (isset($validated['password']) && !is_null($validated['password'])) {
            $user->password = $validated['password']; // Hasher runs in Model
        }

        unset($validated['password']); // Don't try to mass-assign 'password'
        $user->update($validated);

        return response()->json($user);
    }

    /**
     * Allow a user to update their own profile.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:150',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:180',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
            'avatar_url' => 'sometimes|nullable|url',
        ]);

        if (isset($validated['password']) && !is_null($validated['password'])) {
            $user->password = $validated['password']; // Hasher runs in Model
        }

        unset($validated['password']); // Don't try to mass-assign 'password'
        $user->update($validated);
        
        return response()->json($user);
    }
}