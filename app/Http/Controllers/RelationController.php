<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    //
    public function index()
    {
        $data = request()->validate([
            'follower_id'   => 'required', 
            'following_id'  => 'required', 
        ]);

        $user = AUth::user();
        $relation = new Relation();

    }
}
