<?php

namespace App\Http\Controllers\backend\Api\Teachers\dashboard;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileApiController extends Controller
{
    // جلب المعلومات الشخصية للمدرس
    public function index()
    {
        try {
            $information = Teacher::findOrFail(auth()->user()->id);
            return response()->json([
                'status_code' => 200,
                'data' => $information,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error fetching profile information',
                'error' => $e->getMessage(),
            ]);
        }
    }

    // تحديث المعلومات الشخصية للمدرس
    public function update(Request $request)
    {
        try {
            $information = Teacher::findOrFail(auth()->user()->id);

            // التحقق من وجود كلمة المرور في الطلب
            if ($request->filled('password')) {
                $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
                $information->password = Hash::make($request->password);
            } else {
                $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            }

            // حفظ التغييرات
            $information->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Profile updated successfully',
                'data' => $information,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating profile',
                'error' => $e->getMessage(),
            ]);
        }
    }
}