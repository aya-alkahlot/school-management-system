<?php

namespace App\Http\Controllers\backend\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    /**
     * تسجيل دخول API وإرجاع Access Token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = \App\Models\User::where('email', $request->email)->first();
    
        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        // إنشاء التوكن باستخدام `Sanctum`
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    

    /**
     * تسجيل الخروج من API
     */
    public function logout(Request $request)
    {
        // حذف التوكين الخاص بالمستخدم
        $request->user()->tokens()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Logged out successfully | تم تسجيل الخروج بنجاح',
        ]);
    }
}