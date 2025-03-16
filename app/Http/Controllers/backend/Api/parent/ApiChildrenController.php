<?php

namespace App\Http\Controllers\backend\Api\parent;

use App\Models\Degree;
use App\Models\Student;
use App\Models\My_Parent;
use App\Models\Attendance;
use App\Models\Fee_invoice;
use Illuminate\Http\Request;
use App\Models\ReceiptStudent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiChildrenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); // تأكد من التوثيق للـ API
    }

    // عرض جميع الطلاب
    public function index()
    {
        // ✅ التحقق مما إذا كان المستخدم مسجل الدخول
        if (!Auth::check()) {
            return response()->json([
                'status_code' => 401,
                'status_message' => 'User is not authenticated | المستخدم غير مصادق عليه',
            ], 401);
        }

        // ✅ الحصول على بيانات الوالد
        $user = Auth::user();

        // ✅ جلب الطلاب المرتبطين بالوالد
        $students = Student::where('parent_id', $user->id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Children | قائمة الأبناء',
            'data' => $students,
        ]);
    }

    // عرض نتائج الطالب
    public function results($id)
    {
        $student = Student::findOrFail($id);

        if ($student->parent_id !== auth()->user()->id) {
            return response()->json(['message' => 'Invalid student code'], 400);
        }

        $degrees = Degree::where('student_id', $id)->get();

        if ($degrees->isEmpty()) {
            return response()->json(['message' => 'No results for this student'], 404);
        }

        return response()->json($degrees);
    }

    // عرض حضور الطلاب
    public function attendances()
    {
        $students = Student::where('parent_id', auth()->user()->id)->get();
        return response()->json($students);
    }

    // البحث في الحضور حسب التاريخ
    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'End date must be greater than or equal to the start date.',
            'from.date_format' => 'The date format should be yyyy-mm-dd.',
            'to.date_format' => 'The date format should be yyyy-mm-dd.',
        ]);

        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();

        if ($request->student_id == 0) {
            $attendances = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
            return response()->json(['attendances' => $attendances, 'students' => $students]);
        } else {
            $attendances = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)
                ->get();
            return response()->json(['attendances' => $attendances, 'students' => $students]);
        }
    }

    // عرض الفواتير
    public function fees()
    {
        $students_ids = Student::where('parent_id', auth()->user()->id)->pluck('id');
        $fee_invoices = Fee_invoice::whereIn('student_id', $students_ids)->get();
        return response()->json($fee_invoices);
    }

    // عرض سندات القبض
    public function receiptStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->parent_id !== auth()->user()->id) {
            return response()->json(['message' => 'Invalid student code'], 400);
        }

        $receipt_students = ReceiptStudent::where('student_id', $id)->get();

        if ($receipt_students->isEmpty()) {
            return response()->json(['message' => 'No payments found for this student'], 404);
        }

        return response()->json($receipt_students);
    }

    // عرض بيانات الوالد
    public function profile()
    {
        $information = My_Parent::findOrFail(auth()->user()->id);
        return response()->json($information);
    }

    // تحديث بيانات الوالد
    public function update(Request $request, $id)
    {
        $information = My_Parent::findOrFail($id);

        if (!empty($request->password)) {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
