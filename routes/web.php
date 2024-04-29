<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetweetController;
use App\Http\Controllers\FollowerController;


Auth::routes();


//related to Post

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/posts/sort/{sort}', [PostController::class, 'index'])->name('posts.sort');
Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');
//---------------------------------------------------------------------------------------------------------------------


//related to Profile

Route::get('profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('posts', [ProfileController::class, 'create'])->name('post.create');
Route::post('posts', [ProfileController::class, 'store'])->name('post.store');
Route::get('posts/{post}/edit', [ProfileController::class,'edit'])->name('post.edit');
Route::put('posts/{post}/update', [ProfileController::class, 'update'])->name('post.update');
Route::delete('posts/{post}/delete', [ProfileController::class, 'destroy'])->name('post.destroy');
//---------------------------------------------------------------------------------------------------------------------



//related to Comment

Route::get('comments/create', [CommentController::class, 'create'])->middleware('auth')->name('comment.create');
Route::post('posts/comments', [CommentController::class, 'store'])->middleware('auth')->name('posts.comments.store');
Route::get('posts/comments/{post}', [CommentController::class, 'show'])->middleware('auth')->name('posts.comments.show');
Route::delete('comments/{comment}/delete', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');
//--------------------------------------------------------------------------------------------------------------------- 

//related to like/unlike

Route::post('/like-post/{id}',[LikeController::class,'likePost'])->middleware('auth')->name('like.post');
Route::post('/unlike-post/{id}',[LikeController::class,'unlikePost'])->middleware('auth')->name('unlike.post');

//related to Report
Route::post('/report-post/{post_id}', [ReportController::class,'reportpost'])->name('post.report');
//---------------------------------------------------------------------------------------------------------------------

//related to Report

Route::post('/posts/{post_id}/retweet', [RetweetController::class, 'retweet'])->name('retweet.store');
Route::delete('/retweets/{id}', [RetweetController::class, 'delete'])->name('retweet.delete');
//---------------------------------------------------------------------------------------------------------------------

//related to follow
Route::post('follow/{user_id}', [FollowerController::class, 'follow'])->name('follow');
Route::delete('unfollow/{user_id}', [FollowerController::class, 'unfollow'])->name('unfollow');
//---------------------------------------------------------------------------------------------------------------------