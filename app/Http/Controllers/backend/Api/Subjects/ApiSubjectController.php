<?php

namespace App\Http\Controllers\backend\Api\Subjects;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\StoreSubject;
use App\Http\Requests\Subjects\DeleteSubject;
use App\Http\Requests\Subjects\UpdateSubject;

class ApiSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('teacher')->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Subjects | قائمة المواد الدراسية',
            'data' => $subjects,
        ]);
    }


    public function store(StoreSubject $request)
    {
        try {
            $validated = $request->validated();
            $subject = new Subject();
            $subject->name = ['ar' => $request->Name_Ar, 'en' => $request->Name_En];
            $subject->grade_id = $request->Grade_id;
            $subject->classroom_id = $request->Classroom_id ?? null; // تأكد من عدم تركه فارغًا
            $subject->teacher_id = $request->Teacher_id;
            $subject->save();
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Subject created successfully | تم إنشاء المادة الدراسية بنجاح',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating subject | حدث خطأ أثناء إنشاء المادة الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * تحديث مادة دراسية محددة.
     */
    public function update(UpdateSubject $request, $id)
    {
        try {
            $subject = Subject::find($id);
            if (!$subject) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Subject not found | لم يتم العثور على المادة الدراسية',
                ]);
            }

            $subject->update([
                'name' => ['ar' => $request->Name_Ar, 'en' => $request->Name_En],
                'grade_id' => $request->Grade_id,
                'teacher_id' => $request->Teacher_id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Subject updated successfully | تم تحديث المادة الدراسية بنجاح',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating subject | حدث خطأ أثناء تحديث المادة الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف مادة دراسية محددة.
     */
    public function destroy(DeleteSubject $request)
    {
        try {
            $subject = Subject::find($request->id);
            if (!$subject) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Subject not found | لم يتم العثور على المادة الدراسية',
                ]);
            }

            $subject->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Subject deleted successfully | تم حذف المادة الدراسية بنجاح',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting subject | حدث خطأ أثناء حذف المادة الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
