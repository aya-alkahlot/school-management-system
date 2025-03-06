<?php

namespace App\Http\Controllers\backend;

use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
 // Get Classrooms
 public function getClassrooms($id)
 {
     return Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");

 }

 //Get Sections
 public function Get_Sections($id){

     return Section::where("Class_id", $id)->pluck("Name_Section", "id");

 }
}