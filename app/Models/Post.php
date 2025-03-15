<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'imageUrl', 'user_id'];

    function user(){
      return $this->belongsTo(User::class);
    }
}


