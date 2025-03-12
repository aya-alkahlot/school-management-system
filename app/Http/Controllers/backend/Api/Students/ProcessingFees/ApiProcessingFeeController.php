<?php

namespace App\Http\Controllers\backend\Api\Students\ProcessingFees;

use Illuminate\Http\Request;
use App\Models\ProcessingFee;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Students\ProcessingFees\StoreProcessingFees;
use App\Http\Requests\Students\ProcessingFees\UpdateProcessingFees;

class ApiProcessingFeeController extends Controller
{
    public function index()
    {
        $processingFees = ProcessingFee::all();
        return response()->json(['status_code' => 200, 'data' => $processingFees]);
    }

    public function store(StoreProcessingFees $request)
    {
        DB::beginTransaction();
        try {
            $processingFee = ProcessingFee::create([
                'date' => now(),
                'student_id' => $request->student_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            StudentAccount::create([
                'date' => now(),
                'type' => 'ProcessingFee',
                'student_id' => $request->student_id,
                'processing_id' => $processingFee->id,
                'Debit' => 0.00,
                'credit' => $request->amount,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['status_code' => 201, 'message' => 'Processing fee created successfully', 'data' => $processingFee]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function update(UpdateProcessingFees $request, $id)
    {
        DB::beginTransaction();
        try {
            $processingFee = ProcessingFee::findOrFail($id);
            $processingFee->update([
                'date' => now(),
                'student_id' => $request->student_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            $studentAccount = StudentAccount::where('processing_id', $id)->first();
            $studentAccount->update([
                'date' => now(),
                'type' => 'ProcessingFee',
                'student_id' => $request->student_id,
                'credit' => $request->amount,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['status_code' => 200, 'message' => 'Processing fee updated successfully', 'data' => $processingFee]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            ProcessingFee::destroy($id);
            return response()->json(['status_code' => 200, 'message' => 'Processing fee deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }
}
