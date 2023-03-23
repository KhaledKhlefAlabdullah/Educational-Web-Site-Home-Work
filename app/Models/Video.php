<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'video',
    ];
    public function course(){
        return $this->belongsToMany(Course::class,'course_videos','course_id','video_id');
    }
    public function comment(){
        return $this->belongsToMany(Comment::class);
    }
}
