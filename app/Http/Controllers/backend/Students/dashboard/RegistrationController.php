<?php
namespace App\Http\Controllers\backend\Students\dashboard;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Registration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $teachers = $student->teachers;
        $subjects = Subject::whereIn('teacher_id', $teachers->pluck('id'))->get();
        return view('pages.Students.dashboard.subjects.index', compact('student', 'subjects'));
    }
    public function autoRegisterStudent($student_id)
    {
        $student = Student::findOrFail($student_id);
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
    public function show($id)
    {
        $subject = Subject::with('teacher')->findOrFail($id);

        return view('pages.Students.dashboard.subjects.show', compact('subject'));
    }
}