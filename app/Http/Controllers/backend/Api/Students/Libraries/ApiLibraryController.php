<?php

namespace App\Http\Controllers\backend\Api\Students\Libraries;

use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Students\Libraries\StoreLibraries;
use App\Http\Requests\Students\Libraries\UpdateLibraries;

class ApiLibraryController extends Controller
{
    public function index()
    {
        $books = Library::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Books | قائمة الكتب',
            'data' => $books,
        ]);
    }

    /**
     * إضافة كتاب جديد.
     */
    public function store(StoreLibraries $request)
    {
        try {
            $validated = $request->validated();

            $book = new Library();
            $book->title = $validated['title'];
            $book->Grade_id = $validated['Grade_id'];
            $book->classroom_id = $validated['Classroom_id'];
            $book->section_id = $validated['section_id'];
            $book->teacher_id = 1;

            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $filePath = $file->store('library', 'public');
                $book->file_name = $filePath;
            }

            $book->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Book added successfully | تم إضافة الكتاب بنجاح',
                'data' => $book,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error adding book | حدث خطأ أثناء إضافة الكتاب',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث بيانات كتاب محدد.
     */
    public function update(Request $request, $id)
    {
        $library = Library::findOrFail($id);
    
        // تحديث القيم الأخرى
        $library->title = $request->title;
        $library->Grade_id = $request->Grade_id;
        $library->Classroom_id = $request->Classroom_id;
        $library->section_id = $request->section_id;
        $library->teacher_id = $request->teacher_id;
    
        // التحقق من وجود ملف جديد
        if ($request->hasFile('file_name')) {
            // حذف الملف القديم إذا كان موجودًا
            Storage::delete($library->file_name);
    
            // حفظ الملف الجديد
            $path = $request->file('file_name')->store('library_files');
            $library->file_name = $path;
        }
    
        $library->save();
    
        return response()->json(['message' => 'Library updated successfully', 'data' => $library]);
    }
    
    /**
     * حذف كتاب محدد.
     */
    public function destroy($id)
    {
        try {
            $book = Library::find($id);
            if (!$book) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Book not found | لم يتم العثور على الكتاب',
                ]);
            }

            if ($book->file_name) {
                Storage::disk('public')->delete($book->file_name);
            }

            $book->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Book deleted successfully | تم حذف الكتاب بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting book | حدث خطأ أثناء حذف الكتاب',
                'error' => $e->getMessage(),
            ]);
        }
    }

  
   
}
