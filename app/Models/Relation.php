<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;  

    // protected $attributes = [
    //     'status'    => 'Not Following',
    //     'block' => false,
    // ];

    protected $fillable = [
        'follower_id',
        'following_id',
        'status',
    ];
 
}
