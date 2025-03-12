<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{  
     use HasFactory;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'attendances';

    // الحقول التي يمكن تعبئتها
    protected $fillable = [
        'student_id',
        'grade_id',
        'classroom_id',
        'section_id',
        'teacher_id',
        'attendence_date',
        'attendence_status',
    ];

    // تحويل الحقول إلى أنواع بيانات محددة
    protected $casts = [
        'attendence_status' => 'integer', // تأكد من أن الحقل يتم التعامل معه كعدد صحيح
    ];

    // علاقة مع نموذج الطالب
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // علاقة مع نموذج المرحلة الدراسية
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    // علاقة مع نموذج الصف الدراسي
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    // علاقة مع نموذج القسم
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // علاقة مع نموذج المعلم
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}