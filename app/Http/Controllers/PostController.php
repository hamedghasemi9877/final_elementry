<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller{

   

    public function index(Request $request, $sort='newest') {

        $user = auth()->user();
        
        if($user){
         if($sort=='newest'){
             $posts = Post::withCount(['likes', 'comments'])
             ->orderBy('created_at', 'desc')
             ->paginate(10);
         }
         if($sort=='likeable'){
             $posts = Post::withCount(['likes', 'comments'])
             ->orderBy('likes_count', 'desc')
             ->paginate(10);
         }
         if($sort=='commentable'){
             $posts = Post::withCount(['likes', 'comments'])
             ->orderBy('comments_count', 'desc')
             ->paginate(10);
         }

         $users = User::where('visibility','private' )->get();
         $following_id =Follower::where('user_id', $user->id)->pluck('following_id');
    
         $followerPosts = Post::whereIn('user_id', $following_id)->get();
        
         

if($followerPosts){
    
            return view('post.index', compact('posts','user','users','followerPosts'));
 
        }else{
            
            return view('post.index', compact('posts','user','users'));
}

}

if($sort=='newest'){
    $posts = Post::withCount(['likes', 'comments'])
    ->orderBy('created_at', 'desc')
    ->paginate(10);
}
if($sort=='likeable'){
    $posts = Post::withCount(['likes', 'comments'])
    ->orderBy('likes_count', 'desc')
    ->paginate(10);
}
if($sort=='commentable'){
    $posts = Post::withCount(['likes', 'comments'])
    ->orderBy('comments_count', 'desc')
    ->paginate(10);
}
$users = User::where('visibility','private' )->get();
return view('post.index', compact('posts','users'));
        }}
        
    
                                                                                                                 