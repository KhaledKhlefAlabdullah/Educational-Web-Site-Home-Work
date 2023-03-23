<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'first_name',
      'last_name',
      'birth_date',
      'phone_number',
      'whatsapp_link',
      'github_link',
      'facebook_link',
      'instagram_link',
      'user_type'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function images(){
        return $this->belongsToMany(Image::class,'users_images','details_id','image_id');
    }

}
