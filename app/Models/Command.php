<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
   protected $fillable = [
        'vendor','protocol','task','command','description','favorite','usage_count'
    ];

    public function favoriters(){
  return $this->belongsToMany(\App\Models\User::class, 'command_favorites')->withTimestamps();
}
}
