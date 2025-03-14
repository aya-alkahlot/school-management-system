<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasTranslations, HasFactory;

 
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded = [];

    // علاقة بين المعلمين والتخصصات لجلب اسم التخصص
    public function specializations()
    {
        return $this->belongsTo('App\Models\Specialization', 'Specialization_id');
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم
    public function genders()
    {
        return $this->belongsTo('App\Models\Gender', 'Gender_id');
    }

    // علاقة المعلمين مع الاقسام
    public function Sections()
    {
        return $this->belongsToMany('App\Models\Section', 'teacher_section');
    }

    // علاقة المعلمين مع الطلاب عبر `registrations`
    public function students()
    {
        return $this->belongsToMany(Student::class, 'registrations', 'teacher_id', 'student_id')
            ->withPivot('subject_id');
    }

    // علاقة المعلمين مع المواد الدراسية
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }
}