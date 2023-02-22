<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'birth_date',
      'phone_number',
      'whatsapp_link',
      'github_link',
      'facebook_link',
      'instagram_link',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
