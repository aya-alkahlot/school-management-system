<?php

namespace App\Http\Controllers\backend\Api\Students\AddStudents;

use Log;
use App\Models\Image;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\AddStudents\StoreStudentRequest;
use App\Http\Requests\Students\AddStudents\UpdateStudentRequest;

class StudentApiController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Students | قائمة الطلاب',
            'data' => $students,
        ]);
    }

    /**
     * عرض تفاصيل طالب معين.
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Student not found | لم يتم العثور على الطالب',
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Student details | تفاصيل الطالب',
            'data' => $student,
        ]);
    }

    /**
     * إنشاء طالب جديد.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $validated = $request->validated();
            $student = new Student();
            $student->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $student->email = $request->email;
            $student->password = bcrypt($request->password);
            $student->gender_id = $request->gender_id;
            $student->nationalitie_id = $request->nationalitie_id;
            $student->blood_id = $request->blood_id;
            $student->Date_Birth = $request->Date_Birth;
            $student->Grade_id = $request->Grade_id;
            $student->Classroom_id = $request->Classroom_id;
            $student->section_id = $request->section_id;
            $student->parent_id = $request->parent_id;
            $student->academic_year = $request->academic_year;
            $student->save();

            // التعامل مع الصور
            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $filename = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$student->id, $filename, 'upload_attachments');
                    $image = new Image();
                    $image->filename = $filename;
                    $image->imageable_id = $student->id;
                    $image->imageable_type = 'App\Models\Student';
                    $image->save();
                }
            }

            return response()->json([
                'status_code' => 201,
                'status_message' => 'Student created successfully | تم إنشاء الطالب بنجاح',
                'data' => $student,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating student | حدث خطأ أثناء إنشاء الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث طالب معين.
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $student = Student::find($id);
            if (!$student) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Student not found | لم يتم العثور على الطالب',
                ]);
            }

            $student->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'email' => $request->email,
                'gender_id' => $request->gender_id,
                'nationalitie_id' => $request->nationalitie_id,
                'blood_id' => $request->blood_id,
                'Date_Birth' => $request->Date_Birth,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'parent_id' => $request->parent_id,
                'academic_year' => $request->academic_year,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Student updated successfully | تم تحديث الطالب بنجاح',
                'data' => $student,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating student | حدث خطأ أثناء تحديث الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف طالب معين.
     */
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
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting student | حدث خطأ أثناء حذف الطالب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تصفية الطلاب حسب المرحلة الدراسية.
     */
    public function filterByGrade(Request $request)
    {
        try {
            if (!$request->has('Grade_id')) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Missing Grade_id parameter | يجب تحديد المرحلة الدراسية',
                ]);
            }

            $students = Student::where('Grade_id', $request->Grade_id)->get();

            if ($students->isEmpty()) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'No students found for this Grade | لم يتم العثور على طلاب لهذه المرحلة',
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Filtered Students | تم تصفية الطلاب بنجاح',
                'data' => $students,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error filtering students | حدث خطأ أثناء تصفية الطلاب',
                'error' => $e->getMessage(),
            ]);
        }
    }
}