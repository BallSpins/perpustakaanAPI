<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'password' => 'required',
        ]);

        $user = User::find($request->user_id);

        if (!$user || $request->password !== $user->password) {
            // return response()->json(['password'=> $user->password]);
            throw ValidationException::withMessages([
                'user_id' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
