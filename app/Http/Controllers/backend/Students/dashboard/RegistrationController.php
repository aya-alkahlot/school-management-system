<?php

namespace App\Http\Controllers\backend\Students\dashboard;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Registration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
       /**
     * عرض قائمة المواد الدراسية التي يدرسها المعلم الخاص بالطالب.
     */
    public function index()
    {
        // جلب بيانات الطالب المسجل حاليًا
        $student = Auth::user();

        // جلب جميع المعلمين الذين يدرّسون لهذا الطالب عبر `registrations`
        $teachers = $student->teachers;

        // جلب جميع المواد التي يدرّسها هؤلاء المعلمون
        $subjects = Subject::whereIn('teacher_id', $teachers->pluck('id'))->get();

        return view('pages.Students.dashboard.subjects.index', compact('student', 'subjects'));
    }

    /**
     * تسجيل الطالب تلقائيًا في المواد التي يدرّسها معلمه عند انضمامه.
     */
    public function autoRegisterStudent($student_id)
    {
        $student = Student::findOrFail($student_id);

        // جلب جميع المواد التي يدرسها الطالب بناءً على مرحلته الدراسية وصفه
        $subjects = Subject::where('grade_id', $student->Grade_id)
            ->where('classroom_id', $student->Classroom_id)
            ->get();

        foreach ($subjects as $subject) {
            Registration::updateOrCreate([
                'student_id' => $student->id,
                'subject_id' => $subject->id,
            ], [
                'teacher_id' => $subject->teacher_id,
            ]);
        }

        return redirect()->back()->with('success', 'تم تسجيل الطالب تلقائيًا في جميع المواد الخاصة به.');
    }

    /**
     * عرض مادة دراسية معينة للطالب.
     */
    public function show($id)
    {
        $subject = Subject::with('teacher')->findOrFail($id);

        return view('pages.Students.dashboard.subjects.show', compact('subject'));
    }
}