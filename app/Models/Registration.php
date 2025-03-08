<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'teacher_id'];

    // علاقة التسجيل مع الطالب
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // علاقة التسجيل مع المادة الدراسية
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // علاقة التسجيل مع المعلم
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}