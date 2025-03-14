<?php

namespace App\Http\Controllers\backend\Api\Teachers\dashboard;

use Exception;
use App\Models\Section;
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

    // ✅ قائمة الأقسام الخاصة بالمعلم
    public function sections()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $sections = Section::whereIn('id', $ids)->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of sections | قائمة الأقسام',
            'data' => $sections,
        ]);
    }

    // ✅ تسجيل الحضور
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

    // ✅ تقرير الحضور
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

    // ✅ البحث في الحضور بين تاريخين
    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from'  => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد أن يكون أكبر من أو يساوي تاريخ البداية',
            'from.date_format' => 'صيغة التاريخ يجب أن تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب أن تكون yyyy-mm-dd',
        ]);

        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();

        $query = Attendance::whereBetween('attendence_date', [$request->from, $request->to]);

        if ($request->student_id != 0) {
            $query->where('student_id', $request->student_id);
        }

        $Students = $query->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Filtered Attendance Report | تقرير الحضور بناءً على البحث',
            'data' => $Students,
        ]);
    }
}