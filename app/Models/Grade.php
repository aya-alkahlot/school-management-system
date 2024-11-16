<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Grade extends Model
{
    use HasRoles;
    use HasFactory;
    use HasTranslations;

    public $translatable = ['Name'];
    protected $fillable = ['Name', 'Notes'];
    protected $table = 'Grades';
    public $timestamps = true;
}



