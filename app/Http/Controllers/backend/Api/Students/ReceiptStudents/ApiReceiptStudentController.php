<?php

namespace App\Http\Controllers\backend\Api\Students\ReceiptStudents;

use App\Models\FundAccount;
use Illuminate\Http\Request;
use App\Models\ReceiptStudent;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\ReceiptStudents\StoreReceiptStudents;
use App\Http\Requests\Students\ReceiptStudents\UpdateReceiptStudents;

class ApiReceiptStudentController extends Controller
{
    public function index()
    {
        return response()->json(ReceiptStudent::all(), 200);
    }

    public function show($id)
    {
        $receiptStudent = ReceiptStudent::find($id);
        if (!$receiptStudent) {
            return response()->json(['message' => 'Receipt Student not found'], 404);
        }
        return response()->json($receiptStudent, 200);
    }

    public function store(StoreReceiptStudents $request)
    {
        DB::beginTransaction();
        try {
            $receiptStudent = ReceiptStudent::create([
                'date' => now()->toDateString(),
                'student_id' => $request->student_id,
                'Debit' => $request->Debit,
                'description' => $request->description,
            ]);

            FundAccount::create([
                'date' => now()->toDateString(),
                'receipt_id' => $receiptStudent->id,
                'Debit' => $request->Debit,
                'credit' => 0.00,
                'description' => $request->description,
            ]);

            StudentAccount::create([
                'date' => now()->toDateString(),
                'type' => 'receipt',
                'receipt_id' => $receiptStudent->id,
                'student_id' => $request->student_id,
                'Debit' => 0.00,
                'credit' => $request->Debit,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['message' => 'Receipt Student created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateReceiptStudents $request, $id)
    {
        DB::beginTransaction();
        try {
            $receiptStudent = ReceiptStudent::findOrFail($id);
            $receiptStudent->update($request->validated());

            FundAccount::where('receipt_id', $id)->update([
                'date' => now()->toDateString(),
                'Debit' => $request->Debit,
                'description' => $request->description,
            ]);

            StudentAccount::where('receipt_id', $id)->update([
                'date' => now()->toDateString(),
                'student_id' => $request->student_id,
                'Debit' => 0.00,
                'credit' => $request->Debit,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['message' => 'Receipt Student updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
    
            // البحث عن السند المطلوب حذفه
            $receipt_student = ReceiptStudent::findOrFail($id);
    
            // حذف السجلات المرتبطة في FundAccount
            FundAccount::where('receipt_id', $id)->delete();
    
            // حذف السجلات المرتبطة في StudentAccount
            StudentAccount::where('receipt_id', $id)->delete();
    
            // حذف سند القبض نفسه
            $receipt_student->delete();
    
            DB::commit();
            return response()->json(['message' => 'تم حذف سند القبض بنجاح'], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
