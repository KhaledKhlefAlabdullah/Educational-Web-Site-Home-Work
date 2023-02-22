<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
      'comment'
    ];
    public function video(){
        return $this->belongsToMany(Video::class);
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
