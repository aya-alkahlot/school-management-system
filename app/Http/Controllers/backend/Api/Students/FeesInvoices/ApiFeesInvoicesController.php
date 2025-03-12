<?php

namespace App\Http\Controllers\backend\Api\Students\FeesInvoices;

use App\Models\Fee_invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\FeesInvoices\StoreFeesInvoices;
use App\Http\Requests\Students\FeesInvoices\UpdateFeesInvoices;


class ApiFeesInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feesInvoices = Fee_invoice::with(['grade', 'classroom', 'section', 'student', 'fees'])->paginate(10);
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Fees Invoices | قائمة فواتير الرسوم',
            'data' => $feesInvoices,
        ]);
    }

    /**
     * إنشاء فاتورة رسوم جديدة.
     */
    public function store(StoreFeesInvoices $request)
    {
        try {
            // التحقق من صحة البيانات
            $validatedData = $request->validated();
    
            // إنشاء فاتورة جديدة
            $feeInvoice = Fee_invoice::create([
                'invoice_date' => $validatedData['invoice_date'],
                'student_id' => $validatedData['student_id'],
                'Grade_id' => $validatedData['Grade_id'],
                'Classroom_id' => $validatedData['Classroom_id'],
                'fee_id' => $validatedData['fee_id'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'] ?? null, // الوصف اختياري
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم إنشاء فاتورة الرسوم بنجاح',
                'data' => $feeInvoice
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'حدث خطأ أثناء إنشاء فاتورة الرسوم',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * عرض فاتورة رسوم محددة.
     */
    public function show(string $id)
    {
        $feeInvoice = Fee_invoice::with(['grade', 'classroom', 'section', 'student', 'fees'])->find($id);
        if (!$feeInvoice) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Fee Invoice not found | لم يتم العثور على فاتورة الرسوم',
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Fee Invoice details | تفاصيل فاتورة الرسوم',
            'data' => $feeInvoice,
        ]);
    }

    /**
     * تحديث فاتورة رسوم محددة.
     */
    public function update(UpdateFeesInvoices $request, string $id)
    {
        try {
            $feeInvoice = Fee_invoice::find($id);
            if (!$feeInvoice) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'لم يتم العثور على فاتورة الرسوم',
                ], 404);
            }
            $validatedData = $request->validated();
            $feeInvoice->update([
                'invoice_date' => $validatedData['invoice_date'] ?? $feeInvoice->invoice_date,
                'student_id' => $validatedData['student_id'] ?? $feeInvoice->student_id,
                'Grade_id' => $validatedData['Grade_id'] ?? $feeInvoice->Grade_id,
                'Classroom_id' => $validatedData['Classroom_id'] ?? $feeInvoice->Classroom_id,
                'fee_id' => $validatedData['fee_id'] ?? $feeInvoice->fee_id,
                'amount' => $validatedData['amount'] ?? $feeInvoice->amount,
                'description' => $validatedData['description'] ?? $feeInvoice->description,
                'updated_at' => now(),
            ]);
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'تم تحديث فاتورة الرسوم بنجاح',
                'data' => $feeInvoice,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'حدث خطأ أثناء تحديث فاتورة الرسوم',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * حذف فاتورة رسوم محددة.
     */
    public function destroy($id)
    {
        try {
            $feeInvoice = Fee_invoice::find($id);
            if (!$feeInvoice) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Fee Invoice not found | لم يتم العثور على فاتورة الرسوم',
                ]);
            }

            $feeInvoice->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Fee Invoice deleted successfully | تم حذف فاتورة الرسوم بنجاح',
                'data' => $feeInvoice,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting fee invoice | حدث خطأ أثناء حذف فاتورة الرسوم',
                'error' => $e->getMessage(),
            ]);
        }
    }
}