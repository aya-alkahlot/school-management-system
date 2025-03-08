<?php

namespace App\Http\Controllers\backend\Api\Grades;

use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Grades\StoreGrades;
use App\Http\Requests\Grades\UpdateGrades;

class ApiGradeController extends Controller
{
   
        /**
         * عرض جميع المراحل الدراسية مع التصفح.
         */
        public function index()
        {
            $Grades = Grade::paginate(10);
            return response()->json([
                'status_code' => 200,
                'status_message' => 'List of Grades | قائمة المراحل الدراسية',
                'data' => $Grades,
            ]);
        }
    
        /**
         * إنشاء مرحلة دراسية جديدة.
         */
        public function store(StoreGrades $request)
        {
            try {
                $validated = $request->validated();
                $Grade = new Grade();
                $Grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
                $Grade->Notes = $request->Notes;
                $Grade->save();
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Grade created successfully | تم إنشاء المرحلة الدراسية بنجاح',
                    'data' => $Grade,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Error creating grade | حدث خطأ أثناء إنشاء المرحلة الدراسية',
                    'error' => $e->getMessage(),
                ]);
            }
        }
    
        /**
         * تحديث مرحلة دراسية محددة.
         */
        public function update(UpdateGrades $request, $id)
        {
            try {
                $Grade = Grade::find($id);
                if (!$Grade) {
                    return response()->json([
                        'status_code' => 404,
                        'status_message' => 'Grade not found | لم يتم العثور على المرحلة الدراسية',
                    ]);
                }
    
                $Grade->update([
                    'Name' => ['ar' => $request->Name, 'en' => $request->Name_en],
                    'Notes' => $request->Notes,
                ]);
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Grade updated successfully | تم تحديث المرحلة الدراسية بنجاح',
                    'data' => $Grade,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Error updating grade | حدث خطأ أثناء تحديث المرحلة الدراسية',
                    'error' => $e->getMessage(),
                ]);
            }
        }
    
        /**
         * حذف مرحلة دراسية محددة.
         */
        public function destroy($id)
        {
            try {
                $MyClass_id = Classroom::where('Grade_id', $id)->pluck('Grade_id');
                if ($MyClass_id->count() == 0) {
                    $Grade = Grade::find($id);
                    if (!$Grade) {
                        return response()->json([
                            'status_code' => 404,
                            'status_message' => 'Grade not found | لم يتم العثور على المرحلة الدراسية',
                        ]);
                    }
                    $Grade->delete();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Grade deleted successfully | تم حذف المرحلة الدراسية بنجاح',
                        'data' => $Grade,
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 400,
                        'status_message' => 'Cannot delete Grade with associated classrooms | لا يمكن حذف المرحلة الدراسية لوجود فصول مرتبطة بها',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Error deleting grade | حدث خطأ أثناء حذف المرحلة الدراسية',
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
    