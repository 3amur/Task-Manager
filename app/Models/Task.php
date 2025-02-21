<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'status', 'user_id'];

    // relation with user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
