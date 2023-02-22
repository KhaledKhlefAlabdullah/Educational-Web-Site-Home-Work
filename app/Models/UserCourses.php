<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourses extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
    ];
    use HasFactory;

}
