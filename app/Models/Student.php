<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    use HasTranslations;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public $translatable = ['name'];
    protected $guarded = [];

    // علاقة بين الطلاب والأنواع لجلب اسم النوع في جدول الطلاب
    public function gender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    // علاقة بين الطلاب والمراحل الدراسية لجلب اسم المرحلة في جدول الطلاب
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }

    // علاقة بين الطلاب والصفوف الدراسية لجلب اسم الصف في جدول الطلاب
    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }

    // علاقة بين الطلاب والأقسام الدراسية لجلب اسم القسم في جدول الطلاب
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    // علاقة بين الطلاب والصور لجلب اسم الصور في جدول الطلاب
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    // علاقة بين الطلاب والجنسيات لجلب اسم الجنسية في جدول الجنسيات
    public function Nationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationalitie_id');
    }

    // علاقة بين الطلاب والأباء لجلب اسم الأب في جدول الأباء
    public function myparent()
    {
        return $this->belongsTo('App\Models\My_Parent', 'parent_id');
    }

    // علاقة بين جدول سدادت الطلاب وجدول الطلاب لجلب إجمالي المدفوعات والمتبقي
    public function student_account()
    {
        return $this->hasMany('App\Models\StudentAccount', 'student_id');
    }

    // علاقة بين جدول الطلاب وجدول الحضور والغياب
    public function attendance() // تم تغيير الاسم إلى attendances
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    // العلاقة بين الطلاب والمعلمين عبر جدول `registrations`
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'registrations', 'student_id', 'teacher_id')
            ->withPivot('subject_id');
    }

    // جلب المواد الدراسية الخاصة بالطالب بناءً على المعلم
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'registrations', 'student_id', 'subject_id')
            ->withPivot('teacher_id')
            ->with(['teacher']); // جلب بيانات المعلم المسؤول عن المادة
    }


    public function onlineClasses()
    {
        return $this->hasManyThrough(
            online_classe::class,
            Subject::class,
            'id',          // Foreign key on subjects table
            'id',          // Foreign key on online_classes table
            'id',          // Local key on students table
            'id'           // Local key on subjects table
        )->whereHas('subjects', function($query) {
            $query->whereHas('students', function($q) {
                $q->where('students.id', $this->id);
            });
        });
    }
}