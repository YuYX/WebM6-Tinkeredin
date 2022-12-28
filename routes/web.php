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
    return view('auth/login');
    // return view('welcome');
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
[App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit'); 

Route::resource('post', App\Http\Controllers\PostController::class);  

Route::get('/search', 
[App\Http\Controllers\SearchController::class,'search'])->name('search');

Route::get('/search/search_follower',
[App\Http\Controllers\SearchController::class,'search_follower'])->name('search.search_follower');  

Route::get('/search/request_received',
[App\Http\Controllers\SearchController::class,'request_received'])->name('search.request_received'); 

Route::get('/search/search_following',
[App\Http\Controllers\SearchController::class,'search_following'])->name('search.search_following'); 

Route::get('/search/request_sent',
[App\Http\Controllers\SearchController::class,'request_sent'])->name('search.request_sent'); 

Route::get('/search/{follower_id}/{following_id}/{status}/follow',
[App\Http\Controllers\RelationController::class, 'follow'])->name('search.follow'); 

Route::get('/relation/{follower_id}/{following_id}/{status}/follow',
[App\Http\Controllers\RelationController::class, 'follow'])->name('relation.follow'); 

Route::get('/like/{like_post_id}/{like_user_id}/{like}/update', 
[App\Http\Controllers\LikeController::class, 'update'])->name('like.update');

Route::get('/like/{like_post_id}/{like_user_id}/{like}/refresh', 
[App\Http\Controllers\LikeController::class, 'refresh'])->name('like.refresh');

Route::get('/comment/store', 
[App\Http\Controllers\CommentController::class, 'store'])->name('comment.store'); 

// Route::get('/comment/{comment_post_id}/{comment_user_id}/{comment}/store', 
// [App\Http\Controllers\CommentController::class, 'store'])->name('comment.store'); 

Route::get('/comment/{comment_post_id}/show', 
[App\Http\Controllers\CommentController::class, 'show'])->name('comment.show');

Route::get('/comment/{comment_id}/destroy', 
[App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.destroy');
 

 