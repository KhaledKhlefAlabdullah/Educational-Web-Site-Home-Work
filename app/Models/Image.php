<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * @var false|mixed|string
     */

    protected $fillable=[
        'title',
        'image',

    ];
    public function course(){
        return $this->belongsToMany(Course::class);
    }
    public function details(){
        return $this->belongsToMany(Details::class,'users_images','details_id','image_id');
    }


}
