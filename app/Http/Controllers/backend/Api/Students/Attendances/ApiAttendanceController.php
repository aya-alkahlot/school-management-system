<?php

namespace App\Http\Controllers\backend\Api\Students\Attendances;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Attendances\StoreAttendances;

class ApiAttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Attendances | قائمة الحضور',
            'data' => $attendances,
        ]);
    }

    /**
     * إضافة سجل حضور جديد
     */
    public function store(StoreAttendances $request)
    {
        // حفظ البيانات في قاعدة البيانات
        $attendance = Attendance::create($request->validated());

        return response()->json([
            'status_code' => 201,
            'status_message' => 'Attendance created successfully | تم تسجيل الحضور بنجاح',
            'data' => $attendance,
        ]);
    }

    /**
     * عرض تفاصيل حضور محدد
     */
    public function show(string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Attendance not found | لم يتم العثور على سجل الحضور',
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Attendance details | تفاصيل الحضور',
            'data' => $attendance,
        ]);
    }

    /**
     * تحديث بيانات حضور محدد
     */
    public function update(StoreAttendances $request, string $id)
    {
        try {
            $attendance = Attendance::find($id);

            if (!$attendance) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Attendance not found | لم يتم العثور على سجل الحضور',
                ]);
            }

            $attendance->update($request->validated());

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Attendance updated successfully | تم تحديث سجل الحضور بنجاح',
                'data' => $attendance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating attendance | حدث خطأ أثناء تحديث سجل الحضور',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف سجل حضور معين
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::find($id);

            if (!$attendance) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Attendance not found | لم يتم العثور على سجل الحضور',
                ]);
            }

            $attendance->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Attendance deleted successfully | تم حذف سجل الحضور بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting attendance | حدث خطأ أثناء حذف سجل الحضور',
                'error' => $e->getMessage(),
            ]);
        }
    }
}