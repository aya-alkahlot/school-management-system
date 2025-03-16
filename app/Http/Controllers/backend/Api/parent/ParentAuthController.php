<?php

namespace App\Http\Controllers\backend\Api\parent;

use Illuminate\Http\Request;
use App\Models\My_Parent; // تأكد من أن هذا هو نموذج الوالدين لديك
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ParentAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // البحث عن الوالدين من خلال البريد الإلكتروني
        $parent = My_Parent::where('email', $request->email)->first();

        if (!$parent || !Hash::check($request->password, $parent->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // إنشاء Access Token
        $token = $parent->createToken('parent-token')->plainTextToken;

        return response()->json([
            'parent' => $parent,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}