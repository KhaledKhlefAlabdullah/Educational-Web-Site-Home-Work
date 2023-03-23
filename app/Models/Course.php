<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course',
        'description',
        'price',
        'image_id',
        'department_id'
    ];
    use HasFactory;
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function user(){
        return $this->belongsToMany(User::class, 'user_courses', 'user_id', 'course_id');
    }
    public function video(){
        return $this->belongsToMany(Video::class,'course_videos','course_id','video_id');
    }
    public function rating(){
        return $this->belongsToMany(Rating::class);
    }
    public function image(){
        return $this->belongsToMany(Image::class);
    }
}
