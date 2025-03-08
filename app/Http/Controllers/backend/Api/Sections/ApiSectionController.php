<?php

namespace App\Http\Controllers\backend\Api\Sections;

use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\StoreSections;
use App\Http\Requests\Sections\UpdateSections;

class ApiSectionController extends Controller
{
/**
     * عرض جميع الأقسام.
     */
    public function index()
    {
        $sections = Section::with('teachers')->get();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Sections | قائمة الأقسام',
            'data' => $sections,
        ]);
    }

    /**
     * إنشاء قسم جديد.
     */
    public function store(StoreSections $request)
    {
        try {
            $validated = $request->validated();
            $section = new Section();
            $section->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $section->Grade_id = $request->Grade_id;
            $section->Class_id = $request->Class_id;
            $section->Status = isset($request->Status) ? 1 : 2;
            $section->save();

            if ($request->has('teacher_id')) {
                $section->teachers()->attach($request->teacher_id);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Section created successfully | تم إنشاء القسم بنجاح',
                'data' => $section,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating section | حدث خطأ أثناء إنشاء القسم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث قسم محدد.
     */
    public function update(UpdateSections $request, $id)
    {
        try {
            $section = Section::find($id);
            if (!$section) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Section not found | لم يتم العثور على القسم',
                ]);
            }

            $section->update([
                'Name_Section' => ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En],
                'Grade_id' => $request->Grade_id,
                'Class_id' => $request->Class_id,
                'Status' => isset($request->Status) ? 1 : 2,
            ]);

            if ($request->has('teacher_id')) {
                $section->teachers()->sync($request->teacher_id);
            } else {
                $section->teachers()->detach();
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Section updated successfully | تم تحديث القسم بنجاح',
                'data' => $section,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating section | حدث خطأ أثناء تحديث القسم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف قسم محدد.
     */
    public function destroy($id)
    {
        try {
            $section = Section::find($id);
            if (!$section) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Section not found | لم يتم العثور على القسم',
                ]);
            }

            $section->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Section deleted successfully | تم حذف القسم بنجاح',
                'data' => $section,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting section | حدث خطأ أثناء حذف القسم',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * جلب الفصول بناءً على المرحلة الدراسية.
     */
    public function getClassrooms($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Classrooms | قائمة الفصول',
            'data' => $list_classes,
        ]);
    }
}
