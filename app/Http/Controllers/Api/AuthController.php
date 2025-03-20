<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        // Using validator to validate user  input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',  
        ]);
        
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If it succeed then should Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token with user agent (user's device or browser info)
        $token = $user->createToken($request->userAgent())->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
        ], 201);
    }

    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email or password is incorrect'], 401);
        }

        // Also Generate token 
        $token = $user->createToken($request->userAgent())->plainTextToken;

        return response()->json(['token' => $token]);
    }

    
    public function logout(Request $request)
    {
        //This code here is to ensure user is authenticated before logging out
        $request->user()->tokens->each(fn($token) => $token->delete());

        return response()->json(['message' => 'Logged out successfully']);
    }
}
