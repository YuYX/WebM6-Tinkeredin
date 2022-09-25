<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/', 'welcome');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 
[App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', 
[App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

Route::post('/profile/postCreate', 
[App\Http\Controllers\ProfileController::class, 'postCreate'])->name('profile.postCreate');

Route::post('/profile/{id}/postEdit', 
[App\Http\Controllers\ProfileController::class, 'postEdit'])->name('profile.postEdit');


Route::get('/profile/create', 
[App\Http\Controllers\ProfileController::class, 'create']);

Route::get('/profile/edit', 
[App\Http\Controllers\ProfileController::class, 'edit']); 

Route::resource('post', App\Http\Controllers\PostController::class);  

Route::get('/search', 
[App\Http\Controllers\SearchController::class,'search'])->name('search');

Route::get('/relation',
[App\Http\Controllers\SearchController::class, 'follow_request'])->name('follow');

// Route::get('/relation/{follower_id}/{following_id}',
// [App\Http\Controllers\RelationController::class, 'index']);

 