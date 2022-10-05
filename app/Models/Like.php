<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'like_post_id',
        'like_user_id',
        'like',
    ];
}
