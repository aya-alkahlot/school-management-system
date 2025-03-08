<?php

namespace App\Http\Controllers\backend\Api\Classroms;

use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Classrooms\StoreClassrooms;
use App\Http\Requests\Classrooms\UpdateClassrooms;

class ApiClassroomController extends Controller
{
  /**
     * عرض جميع الفصول الدراسية.
     */
    public function index()
    {
        $My_Classes = Classroom::all();
        $Grades = Grade::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Classrooms and Grades | قائمة الفصول والمراحل الدراسية',
            'data' => [
                'classrooms' => $My_Classes,
                'grades' => $Grades,
            ],
        ]);
    }

    /**
     * إنشاء فصل دراسي جديد.
     */
    public function store(StoreClassrooms $request)
    {
        try {
            $validated = $request->validated();
            $List_Classes = $request->List_Classes;
            $createdClasses = [];

            foreach ($List_Classes as $List_Class) {
                $My_Classes = new Classroom();
                $My_Classes->Name_Class = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];
                $My_Classes->Grade_id = $List_Class['Grade_id'];
                $My_Classes->save();
                $createdClasses[] = $My_Classes;
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Classrooms created successfully | تم إنشاء الفصول الدراسية بنجاح',
                'data' => $createdClasses,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating classrooms | حدث خطأ أثناء إنشاء الفصول الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث فصل دراسي محدد.
     */
    public function update(UpdateClassrooms $request, $id)
    {
        try {
            $Classroom = Classroom::find($id);
            if (!$Classroom) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Classroom not found | لم يتم العثور على الفصل الدراسي',
                ]);
            }

            $Classroom->update([
                'Name_Class' => ['ar' => $request->Name, 'en' => $request->Name_en],
                'Grade_id' => $request->Grade_id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Classroom updated successfully | تم تحديث الفصل الدراسي بنجاح',
                'data' => $Classroom,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating classroom | حدث خطأ أثناء تحديث الفصل الدراسي',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف فصل دراسي محدد.
     */
    public function destroy($id)
    {
        try {
            $Classroom = Classroom::find($id);
            if (!$Classroom) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Classroom not found | لم يتم العثور على الفصل الدراسي',
                ]);
            }

            $Classroom->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Classroom deleted successfully | تم حذف الفصل الدراسي بنجاح',
                'data' => $Classroom,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting classroom | حدث خطأ أثناء حذف الفصل الدراسي',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف عدة فصول دراسية دفعة واحدة.
     */
    public function delete_all(Request $request)
    {
        try {
            // التحقق من إرسال delete_all_id في الطلب
            if (!$request->has('delete_all_id')) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Missing delete_all_id parameter | يجب تحديد قائمة الفصول لحذفها',
                ]);
            }
    
            $delete_all_id = $request->input('delete_all_id', []);
    
            if (!is_array($delete_all_id)) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Invalid format. delete_all_id must be an array | يجب إرسال القائمة كمصفوفة',
                ]);
            }
    
            // التحقق من وجود المعرفات في قاعدة البيانات
            $existingClassrooms = Classroom::withTrashed()->whereIn('id', $delete_all_id)->get();
    
            if ($existingClassrooms->isEmpty()) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'No classrooms found for deletion | لم يتم العثور على الفصول المراد حذفها',
                ]);
            }
    
            // تنفيذ الحذف النهائي
            $deletedCount = Classroom::whereIn('id', $delete_all_id)->forceDelete();
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Classrooms deleted successfully | تم حذف الفصول الدراسية بنجاح',
                'deleted_count' => $deletedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting classrooms | حدث خطأ أثناء حذف الفصول الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }
    

    /**
     * تصفية الفصول الدراسية حسب المرحلة الدراسية.
     */
    public function Filter_Classes(Request $request)
    {
        try {
            // التحقق من وجود Grade_id في الطلب
            if (!$request->has('Grade_id')) {
                return response()->json([
                    'status_code' => 400,
                    'status_message' => 'Missing Grade_id parameter | يجب تحديد المرحلة الدراسية',
                ]);
            }
    
            // تنفيذ الاستعلام بناءً على Grade_id
            $Search = Classroom::where('Grade_id', $request->Grade_id)->get();
    
            // التحقق مما إذا كان هناك فصول تم العثور عليها
            if ($Search->isEmpty()) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'No classrooms found for this Grade | لا توجد فصول دراسية لهذه المرحلة',
                ]);
            }
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Filtered Classrooms | تم تصفية الفصول الدراسية بنجاح',
                'data' => $Search,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error filtering classrooms | حدث خطأ أثناء تصفية الفصول الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
