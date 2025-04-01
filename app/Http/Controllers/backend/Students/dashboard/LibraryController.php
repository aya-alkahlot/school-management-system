<?php

namespace App\Http\Controllers\backend\Students\dashboard;

use App\Models\Library;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    /**
     * عرض الكتب الدراسية الخاصة بالطالب بناءً على المواد المسجلة له.
     */
    public function index()
    {
        try {
            // جلب بيانات الطالب المسجل حالياً
            $student = Student::findOrFail(Auth::user()->id);

            // جلب المواد الدراسية الخاصة بالطالب
            $subjects = $student->subjects;
        //    dd($subjects);

            // جلب الكتب الدراسية المرتبطة بالمواد الدراسية
            $books = [];
            foreach ($subjects as $subject) {
/*
                $subjectBooks = Library::where('subject_id', $subject->id)//no subject_id colum in library table
                    ->where('grade_id', $student->Grade_id)
                    ->where('classroom_id', $student->Classroom_id)
                    ->where('section_id', $student->section_id)
                    ->orderBy('id', 'DESC')
                    ->get();


*/
                $subjectBooks = Library::where('grade_id', $student->Grade_id)
                    ->where('classroom_id', $student->Classroom_id)
                    ->where('section_id', $student->section_id)
                    ->orderBy('id', 'DESC')
                    ->get();

                  //  dd($subjectBooks);

                foreach ($subjectBooks as $book) {
                    $book->subject_name = $subject->getTranslation('name', 'ar'); // إضافة اسم المادة بالعربية
                    $books[] = $book;
                }
            }
        //    dd($books);

            // عرض الصفحة مع البيانات
            return view('pages.Students.dashboard.library.index', compact('books'));
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، إعادة توجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    /**
     * تحميل كتاب معين.
     */
    public function download($filename)
    {
        try {
            // التأكد من وجود الملف
            $filePath = public_path('attachments/library/' . $filename);
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'الملف المطلوب غير موجود.');
            }

            // تحميل الملف
            return response()->download($filePath);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، إعادة توجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل الملف: ' . $e->getMessage());
        }
    }

    /**
     * عرض الكتب المحملة من قبل الطالب.
     */
    public function downloaded()
    {
        try {
            // جلب بيانات الطالب المسجل حالياً
            $student = Student::findOrFail(Auth::user()->id);

            // جلب الكتب المحملة من قبل الطالب (يمكن تعديل هذا الجزء بناءً على هيكل قاعدة البيانات)
            $downloadedBooks = []; // يمكن استبدال هذا بمنطق لجلب الكتب المحملة

            // عرض الصفحة مع البيانات
            return view('pages.Students.dashboard.library.downloaded', compact('downloadedBooks'));
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، إعادة توجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    /**
     * البحث عن كتب في المكتبة.
     */
    public function search(Request $request)
    {
        try {
            // جلب الكلمة المفتاحية من البحث
            $query = $request->input('query');

            // البحث عن الكتب التي تطابق الكلمة المفتاحية
            $searchResults = Library::where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orderBy('id', 'DESC')
                ->get();

            // عرض الصفحة مع نتائج البحث
            return view('pages.Students.dashboard.library.search', compact('searchResults', 'query'));
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، إعادة توجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء البحث: ' . $e->getMessage());
        }
    }
}
