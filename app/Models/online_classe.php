<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class online_classe extends Model
{
    protected $casts = [
        'start_at' => 'datetime',
    ];

    protected $fillable = [
        'integration', 'Grade_id', 'Classroom_id', 'section_id',
        'created_by', 'meeting_id', 'topic', 'start_at',
        'duration', 'password', 'start_url', 'join_url'
    ];

    // العلاقات
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

   

        public function subjects()
        {
            return $this->belongsToMany(Subject::class, 'subject_online_class_pivot');
        }

}