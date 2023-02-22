<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course',
        'description',
        'image_id'
    ];
    use HasFactory;
    public function user(){
        return $this->belongsToMany(User::class);
    }
    public function video(){
        return $this->belongsToMany(Video::class);
    }
    public function rating(){
        return $this->belongsToMany(Rating::class);
    }
    public function image(){
        return $this->belongsToMany(Image::class);
    }
}
