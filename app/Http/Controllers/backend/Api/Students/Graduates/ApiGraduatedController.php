<?php

namespace App\Http\Controllers\backend\Api\Students\Graduates;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Graduates\StoreGraduates;
use App\Http\Requests\Students\Graduates\DeleteGraduates;

class ApiGraduatedController extends Controller
{
    public function index()
    {
        $students = Student::onlyTrashed()->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of graduated students | قائمة الطلاب الخريجين',
            'data' => $students,
        ]);
    }

    public function create()
    {
        $Grades = Grade::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Grades data for creating graduates | بيانات المراحل الدراسية لإنشاء خريجين',
            'data' => $Grades,
        ]);
    }

    public function SoftDelete(StoreGraduates $request)
    {
        $students = Student::where('Grade_id', $request->Grade_id)
            ->where('Classroom_id', $request->Classroom_id)
            ->where('section_id', $request->section_id)
            ->get();

        if ($students->count() < 1) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'No students found | لم يتم العثور على طلاب',
            ], 404);
        }

        foreach ($students as $student) {
            $student->delete();
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Students graduated successfully | تم تخرج الطلاب بنجاح',
        ]);
    }

    public function ReturnData(Request $request)
    {
        $student = Student::onlyTrashed()->where('id', $request->id)->first();

        if (!$student) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Student not found | لم يتم العثور على الطالب',
            ], 404);
        }

        $student->restore();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Student restored successfully | تم استعادة الطالب بنجاح',
            'data' => $student,
        ]);
    }

    public function destroy(DeleteGraduates $request)
    {
        $student = Student::onlyTrashed()->where('id', $request->id)->first();

        if (!$student) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Student not found | لم يتم العثور على الطالب',
            ], 404);
        }

        $student->forceDelete();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Student permanently deleted | تم حذف الطالب بشكل نهائي',
        ]);
    }
}