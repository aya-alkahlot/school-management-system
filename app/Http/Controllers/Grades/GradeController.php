<?php

namespace App\Http\Controllers\Grades;

use toastr;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGrades;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades = Grade::paginate(10);
        // $grades = Grade::paginate(10);
        return view('pages.Grades.grades', compact('Grades'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreGrades $request)
    {
        try {
            $validated = $request->validated();
            $Grades = new Grade();

            //   $translations = [
            //       'en' => $request->Name_en,
            //       'ar' => $request->Name
            //   ];
            //   $Grades->setTranslations('Name', $translations);
            $Grades->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
            $Grades->Notes = $request->Notes;
            $Grades->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Grades.index');
            toastr()->success(trans('messages.success'));
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(StoreGrades $request) {
        try {

            $validated = $request->validated();
            $Grades = Grade::findOrFail($request->id);
            $Grades->update([
              $Grades->Name = ['ar' => $request->Name, 'en' => $request->Name_en],
              $Grades->Notes = $request->Notes,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Grades.index');
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
      }
     
       /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return Response
        */
       public function destroy(Request $request)
       {
               $Grades = Grade::findOrFail($request->id)->delete();
               toastr()->error(trans('messages.Delete'));
               return redirect()->route('Grades.index');
           
     
     
       }
    }     