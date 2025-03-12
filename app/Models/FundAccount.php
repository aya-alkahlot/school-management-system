<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'amount',
        'description',
        'date' // أضف هذا الحقل هنا
    ];
    
}
