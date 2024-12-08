<?php

namespace App\Http\Controllers\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentsRequest;
use App\Repository\StudentRepositoryInterface;

class StudentController extends Controller
{

    protected $Student;
    public function __construct(StudentRepositoryInterface $Student)
    {
        $this->Student = $Student;
    }
    public function create()
    {
        return $this->Student->Create_Student();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentsRequest $request)
    {
       return $this->Student->Store_Student($request);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function Get_classrooms($id)
    {
       return $this->Student->Get_classrooms($id);
    }
    public function Get_Sections($id)
    {
       return $this->Student->Get_Sections($id);
    }
}
