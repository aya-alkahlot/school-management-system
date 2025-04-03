<?php

namespace App\Http\Controllers\backend\Students\dashboard;

use Illuminate\Http\Request;
use App\Models\online_classe;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OnlineZoomClassesController extends Controller
{

        public function index()

        {
            $student = Auth::user();
           // dd(DB::table('subject_online_class_pivot')->get()); //

           //dd($student->subjects);

            $online_classes = online_classe::whereHas('subjects', function($query) use ($student) {
                $query->whereHas('students', function($q) use ($student) {
                    $q->where('students.id', $student->id);
                });
            })
            ->orderBy('start_at', 'desc')
            ->get();
          //  dd($online_classes);

            return view('pages.Students.dashboard.online_classes.index', compact('online_classes'));
        }


}