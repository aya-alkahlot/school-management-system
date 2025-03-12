<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStudent extends Model
{
    protected $fillable = [
        'student_id',
        'amount',
        'description',
        'date' // أضف هذا الحقل هنا
    ];
    
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }
}