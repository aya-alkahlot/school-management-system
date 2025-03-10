<?php

namespace App\Http\Controllers\backend\Api\Students;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Attendance\StoreAttendance;
use App\Http\Requests\Students\Attendance\DeleteAttendance;
use App\Http\Requests\Students\Attendance\UpdateAttendance;

class ApiAttendanceController extends Controller
{
     /**
     * عرض جميع الصفوف الدراسية مع الأقسام والمعلمين.
     */
    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
        $teachers = Teacher::all();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Grades and Sections | قائمة الصفوف الدراسية والأقسام',
            'data' => [
                'grades' => $Grades,
                'list_grades' => $list_Grades,
                'teachers' => $teachers,
            ],
        ]);
    }

    /**
     * عرض قائمة الطلاب في قسم معين.
     */
    public function show($id)
    {
        $students = Student::with('attendance')->where('section_id', $id)->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Students with Attendance | قائمة الطلاب مع الحضور',
            'data' => $students,
        ]);
    }

    /**
     * تسجيل الحضور والغياب للطلاب.
     */
    public function store(StoreAttendance $request)
    {
        try {
            foreach ($request->attendances as $studentId => $attendance) {
                $attendance_status = ($attendance == 'presence') ? true : false;
    
                Attendance::create([
                    'student_id' => $studentId,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => $request->teacher_id, // ✅ الآن يتم تمرير الـ teacher_id من الطلب
                    'attendance_date' => date('Y-m-d'),
                    'attendance_status' => $attendance_status,
                ]);
            }
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Attendance recorded successfully | تم تسجيل الحضور بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error recording attendance | حدث خطأ أثناء تسجيل الحضور',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث بيانات الحضور والغياب (يمكن تعديلها لاحقًا).
     */
    public function update(UpdateAttendance $request, $id)
    {
        try {
            $attendance = Attendance::find($id);
            if (!$attendance) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Attendance record not found | لم يتم العثور على سجل الحضور',
                ]);
            }

            $attendance->update([
                'attendance_status' => $request->attendance_status,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Attendance updated successfully | تم تحديث الحضور بنجاح',
                'data' => $attendance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating attendance | حدث خطأ أثناء تحديث الحضور',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف سجل الحضور.
     */
    public function destroy(DeleteAttendance $request, $id)
    {
        try {
            $attendance = Attendance::find($id);
            if (!$attendance) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Attendance record not found | لم يتم العثور على سجل الحضور',
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