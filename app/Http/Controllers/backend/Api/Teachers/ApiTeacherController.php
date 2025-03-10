<?php

namespace App\Http\Controllers\backend\Api\Teachers;

use Exception;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Teachers\StoreTeacher;
use App\Http\Requests\Teachers\UpdateTeacher;


class ApiTeacherController extends Controller
{
       /**
     * جلب جميع المعلمين.
     */
    public function index()
    {
        $Teachers = Teacher::all();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Teachers | قائمة المعلمين',
            'data' => $Teachers,
        ]);
    }

    /**
     * إنشاء معلم جديد.
     */
    public function store(StoreTeacher $request)
    {
        try {
            $validated = $request->validated();

            $teacher = new Teacher();
            $teacher->email = $validated['email'];
            $teacher->password = Hash::make($validated['password']);
            $teacher->Name = ['en' => $validated['Name_en'], 'ar' => $validated['Name_ar']];
            $teacher->Specialization_id = $validated['Specialization_id'];
            $teacher->Gender_id = $validated['Gender_id'];
            $teacher->Joining_Date = $validated['Joining_Date'];
            $teacher->Address = $validated['Address'] ?? null;
            $teacher->save();

            return response()->json([
                'status_code' => 201,
                'status_message' => 'Teacher created successfully | تم إنشاء المعلم بنجاح',
                'data' => $teacher,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating teacher | حدث خطأ أثناء إنشاء المعلم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * جلب بيانات معلم معين.
     */
    public function show($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Teacher data retrieved | تم جلب بيانات المعلم',
                'data' => $teacher,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Teacher not found | لم يتم العثور على المعلم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث بيانات معلم معين.
     */
    public function update(UpdateTeacher $request, $id)
    {
        try {
            $validated = $request->validated();

            $teacher = Teacher::findOrFail($id);
            $teacher->email = $validated['email'];
            if (!empty($validated['password'])) {
                $teacher->password = Hash::make($validated['password']);
            }
            $teacher->Name = ['en' => $validated['Name_en'], 'ar' => $validated['Name_ar']];
            $teacher->Specialization_id = $validated['Specialization_id'];
            $teacher->Gender_id = $validated['Gender_id'];
            $teacher->Joining_Date = $validated['Joining_Date'];
            $teacher->Address = $validated['Address'] ?? null;
            $teacher->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Teacher updated successfully | تم تحديث بيانات المعلم بنجاح',
                'data' => $teacher,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating teacher | حدث خطأ أثناء تحديث بيانات المعلم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف معلم معين.
     */
    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Teacher deleted successfully | تم حذف المعلم بنجاح',
                'data' => $teacher,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting teacher | حدث خطأ أثناء حذف المعلم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف عدة معلمين دفعة واحدة.
     */
    public function delete_all(Request $request)
    {
        try {
            if (!$request->has('delete_all_id')) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Missing delete_all_id parameter | يجب تحديد قائمة المعلمين لحذفهم',
                ]);
            }

            $delete_all_id = $request->input('delete_all_id', []);

            if (!is_array($delete_all_id)) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Invalid format. delete_all_id must be an array | يجب إرسال القائمة كمصفوفة',
                ]);
            }

            $existingTeachers = Teacher::whereIn('id', $delete_all_id)->get();

            if ($existingTeachers->isEmpty()) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'No teachers found for deletion | لم يتم العثور على المعلمين المراد حذفهم',
                ]);
            }

            $deletedCount = Teacher::whereIn('id', $delete_all_id)->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Teachers deleted successfully | تم حذف المعلمين بنجاح',
                'deleted_count' => $deletedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting teachers | حدث خطأ أثناء حذف المعلمين',
                'error' => $e->getMessage(),
            ]);
        }
    }
}