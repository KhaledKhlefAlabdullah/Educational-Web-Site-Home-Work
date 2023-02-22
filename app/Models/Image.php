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
        'userInformation_id'
    ];
    public function course(){
        return $this->belongsToMany(Course::class);
    }


}
