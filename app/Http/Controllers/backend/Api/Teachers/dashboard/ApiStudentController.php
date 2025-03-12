<?php

namespace App\Http\Controllers\backend\Api\Teachers\dashboard;

use Exception;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\dashboard\Student\StoreStudent;
use App\Http\Requests\Teachers\dashboard\Student\UpdateStudent;

class ApiStudentController extends Controller
{
    public function index()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of students | قائمة الطلاب',
            'data' => $students,
        ]);
    }

    public function store(StoreStudent $request)
    {
        try {
            $validated = $request->validated();
            $student = Student::create($validated);
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Student created successfully | تم إنشاء الطالب بنجاح',
                'data' => $student,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating student | حدث خطأ أثناء إنشاء الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateStudent $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->update($request->validated());
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Student updated successfully | تم تحديث بيانات الطالب بنجاح',
                'data' => $student,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating student | حدث خطأ أثناء تحديث بيانات الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::find($id);
            if (!$student) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Student not found | لم يتم العثور على الطالب',
                ]);
            }

            $student->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Student deleted successfully | تم حذف الطالب بنجاح',
                'data' => $student,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting student | حدث خطأ أثناء حذف الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function attendance(Request $request)
    {
        try {
            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence) {
                $attendence_status = $attendence == 'presence';

                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentid,
                        'attendence_date' => $attenddate
                    ],
                    [
                        'student_id' => $studentid,
                        'grade_id' => $request->grade_id,
                        'classroom_id' => $request->classroom_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => auth()->user()->id,
                        'attendence_date' => $attenddate,
                        'attendence_status' => $attendence_status
                    ]
                );
            }
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Attendance recorded successfully | تم تسجيل الحضور بنجاح',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error recording attendance | حدث خطأ أثناء تسجيل الحضور',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function attendanceReport()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Attendance report | تقرير الحضور',
            'data' => $students,
        ]);
    }
}
