<?php

namespace App\Http\Controllers\backend\Api\Students\Promotions;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Promotions\StorePromotions;

class ApiPromotionController extends Controller
{
    public function index()
    {
        return response()->json(['status_code' => 200, 'data' => Grade::all()]);
    }

    public function create()
    {
        return response()->json(['status_code' => 200, 'data' => Promotions::all()]);
    }

    public function store(StorePromotions $request)
    {
        DB::beginTransaction();
        try {
            $students = Student::where('Grade_id', $request->Grade_id)
                ->where('Classroom_id', $request->Classroom_id)
                ->where('section_id', $request->section_id)
                ->where('academic_year', $request->academic_year)
                ->get();

            if ($students->count() < 1) {
                return response()->json(['status_code' => 400, 'error' => 'No students found for promotion.']);
            }

            foreach ($students as $student) {
                $student->update([
                    'Grade_id' => $request->Grade_id_new,
                    'Classroom_id' => $request->Classroom_id_new,
                    'section_id' => $request->section_id_new,
                    'academic_year' => $request->academic_year_new,
                ]);

                Promotions::updateOrCreate([
                    'student_id' => $student->id,
                    'from_grade' => $request->Grade_id,
                    'from_Classroom' => $request->Classroom_id,
                    'from_section' => $request->section_id,
                    'to_grade' => $request->Grade_id_new,
                    'to_Classroom' => $request->Classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'academic_year' => $request->academic_year,
                    'academic_year_new' => $request->academic_year_new,
                ]);
            }
            DB::commit();
            return response()->json(['status_code' => 201, 'message' => 'Students promoted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->page_id == 1) {
                $promotions = Promotions::all();
                foreach ($promotions as $promotion) {
                    Student::where('id', $promotion->student_id)
                        ->update([
                            'Grade_id' => $promotion->from_grade,
                            'Classroom_id' => $promotion->from_Classroom,
                            'section_id' => $promotion->from_section,
                            'academic_year' => $promotion->academic_year,
                        ]);
                }
                Promotions::truncate();
            } else {
                $promotion = Promotions::findOrFail($request->id);
                Student::where('id', $promotion->student_id)
                    ->update([
                        'Grade_id' => $promotion->from_grade,
                        'Classroom_id' => $promotion->from_Classroom,
                        'section_id' => $promotion->from_section,
                        'academic_year' => $promotion->academic_year,
                    ]);
                $promotion->delete();
            }
            DB::commit();
            return response()->json(['status_code' => 200, 'message' => 'Promotion reverted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }
}
