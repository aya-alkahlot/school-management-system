<?php

namespace App\Http\Controllers\backend\Api\Students\Payments;

use App\Models\FundAccount;
use Illuminate\Http\Request;
use App\Models\PaymentStudent;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\Payments\StorePayments;
use App\Http\Requests\Students\Payments\UpdatePayments;

class ApiPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_students = PaymentStudent::all();
        return response()->json(['status_code' => 200, 'data' => $payment_students]);
    }

    /**
     * إنشاء مدفوعات جديدة.
     */
    public function store(StorePayments $request)
    {
        DB::beginTransaction();
        try {
            $payment = PaymentStudent::create([
                'student_id' => $request->student_id,
                'amount' => $request->amount, // تأكد من استخدام request مباشرة
                'description' => $request->description,
                'date' => now()
            ]);

            FundAccount::create([
                'date' => now(),
                'payment_id' => $payment->id,
                'Debit' => 0.00,
                'credit' => $request->Debit,
                'description' => $request->description,
            ]);

            StudentAccount::create([
                'date' => now(),
                'type' => 'payment',
                'student_id' => $request->student_id,
                'payment_id' => $payment->id,
                'Debit' => $request->Debit,
                'credit' => 0.00,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['status_code' => 200, 'message' => 'Payment created successfully', 'data' => $payment]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * تحديث مدفوعات محددة.
     */
    public function update(UpdatePayments $request, $id)
    {
        DB::beginTransaction();
        try {
            $payment = PaymentStudent::findOrFail($id);
            $payment->update([
                'date' => now(),
                'student_id' => $request->student_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            FundAccount::where('payment_id', $id)->update([
                'date' => now(),
                'credit' => $request->Debit,
                'description' => $request->description,
            ]);

            StudentAccount::where('payment_id', $id)->update([
                'date' => now(),
                'student_id' => $request->student_id,
                'Debit' => $request->Debit,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['status_code' => 200, 'message' => 'Payment updated successfully', 'data' => $payment]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * حذف مدفوعات محددة.
     */
    public function destroy($id)
    {
        try {
            PaymentStudent::destroy($id);
            return response()->json(['status_code' => 200, 'message' => 'Payment deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }}