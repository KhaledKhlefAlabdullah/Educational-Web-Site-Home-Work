<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable=[
      'rating',
      'not'
    ];
    public function course(){
        return $this->belongsToMany(Course::class);
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
