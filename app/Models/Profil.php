<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected  $fillable = ["user_id","bio", "image"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
