<?php

namespace App\Http\Controllers\backend\Api\Students\Fees;

use App\Models\Fee;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Fees\StoreFeesRequest;
use App\Http\Requests\Students\Fees\UpdateFeesRequest;

class ApiFeesController extends Controller
{
  
    /**
     * عرض جميع الرسوم الدراسية مع التصفح.
     */
    public function index()
    {
        $fees = Fee::paginate(10);
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Fees | قائمة الرسوم الدراسية',
            'data' => $fees,
        ]);
    }

    /**
     * إنشاء رسوم دراسية جديدة.
     */
    public function store(StoreFeesRequest $request)
    {
        try {
            $validated = $request->validated();
            $fee = Fee::create([
                'title' => ['en' => $request->title_en, 'ar' => $request->title_ar], // تأكد من استخدام title_ar
                'amount' => $request->amount,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'year' => $request->year,
                'description' => $request->description,
                'Fee_type' => $request->Fee_type,
            ]);
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Fee created successfully | تم إنشاء الرسوم الدراسية بنجاح',
                'data' => $fee,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating fee | حدث خطأ أثناء إنشاء الرسوم الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * عرض تفاصيل رسوم دراسية محددة.
     */
    public function show(string $id)
    {
        $fee = Fee::find($id);

        if (!$fee) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Fee not found | لم يتم العثور على الرسوم الدراسية',
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Fee details | تفاصيل الرسوم الدراسية',
            'data' => $fee,
        ]);
    }

    /**
     * تحديث رسوم دراسية محددة.
     */
    public function update(UpdateFeesRequest $request, string $id)
    {
        try {
            $fee = Fee::find($id);
    
            if (!$fee) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Fee not found | لم يتم العثور على الرسوم الدراسية',
                ]);
            }
    
            $validated = $request->validated();
    
            // تحقق من أن title هو مصفوفة
            $title = $fee->title;
            if (!is_array($title)) {
                $title = ['en' => $title, 'ar' => $title]; // تحويله إلى مصفوفة إذا كان نصًا
            }
    
            // تحديث البيانات
            $fee->update([
                'title' => [
                    'en' => $request->input('title.en', $title['en']), // إذا لم يتم إرسال title.en، استخدم القيمة الحالية
                    'ar' => $request->input('title.ar', $title['ar']), // إذا لم يتم إرسال title.ar، استخدم القيمة الحالية
                ],
                'amount' => $request->input('amount', $fee->amount),
                'Grade_id' => $request->input('Grade_id', $fee->Grade_id),
                'Classroom_id' => $request->input('Classroom_id', $fee->Classroom_id),
                'year' => $request->input('year', $fee->year),
                'description' => $request->input('description', $fee->description),
                'Fee_type' => $request->input('Fee_type', $fee->Fee_type), // تأكد من أن Fee_type يتم معالجته بشكل صحيح
            ]);
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Fee updated successfully | تم تحديث الرسوم الدراسية بنجاح',
                'data' => $fee,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating fee | حدث خطأ أثناء تحديث الرسوم الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }
    /**
     * حذف رسوم دراسية محددة.
     */
    public function destroy(string $id)
    {
        try {
            $fee = Fee::find($id);

            if (!$fee) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Fee not found | لم يتم العثور على الرسوم الدراسية',
                ]);
            }

            $fee->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Fee deleted successfully | تم حذف الرسوم الدراسية بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting fee | حدث خطأ أثناء حذف الرسوم الدراسية',
                'error' => $e->getMessage(),
            ]);
        }
    }
}