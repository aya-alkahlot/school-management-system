<?php

namespace App\Http\Controllers\backend\Api\Students\dashboard\StudentRegistrations;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\dashboard\StudentRegistrations\StoreStudentRegistrations;
use App\Http\Requests\Students\dashboard\StudentRegistrations\UpdateStudentRegistrations;

class ApiStudentRegistrationController extends Controller
{
    /**
     * عرض جميع التسجيلات الطلابية.
     */
    public function index()
    {
        $registrations = Registration::with(['student', 'subject', 'teacher'])->paginate(10);

        return response()->json([
            'status_code' => 200,
            'status_message' => 'تم جلب التسجيلات الطلابية بنجاح',
            'data' => $registrations,
        ]);
    }

    /**
     * تسجيل طالب في مادة دراسية.
     */
    public function store(StoreStudentRegistrations $request)
    {
        try {
            $registration = Registration::create($request->validated());

            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم تسجيل الطالب في المادة الدراسية بنجاح',
                'data' => $registration,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'حدث خطأ أثناء تسجيل الطالب',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * عرض تسجيل طالب معين.
     */
    public function show($id)
    {
        try {
            $registration = Registration::with(['student', 'subject', 'teacher'])->findOrFail($id);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم جلب التسجيل بنجاح',
                'data' => $registration,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'التسجيل غير موجود',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * تحديث تسجيل طالب معين.
     */
    public function update(UpdateStudentRegistrations $request, $id)
    {
        try {
            // $registration = Registration::findOrFail($id);
            $registration = Registration::find($id);
            if (!$registration) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'التسجيل غير موجود'
                ], 404);
            }

            $registration->update($request->validated());

            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم تحديث التسجيل بنجاح',
                'data' => $registration,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'حدث خطأ أثناء تحديث التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * حذف تسجيل طالب معين.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $registration = Registration::find($id);
            if (!$registration) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'التسجيل غير موجود'
                ], 404);
            }
            $registration->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم حذف التسجيل بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'حدث خطأ أثناء حذف التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
