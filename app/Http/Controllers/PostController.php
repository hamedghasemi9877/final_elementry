<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Follower;
use Conner\Likeable\Like;
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
         

        // the posts that user like them
        $postslikes = Like::where('user_id',$user->id)->pluck('likeable_id');
        // dd( $postslikes );

        //the user_id  of posts
        $likedowners= Post::whereIn('id', $postslikes)->pluck('user_id');
        // dd( $likedowners );

        // owners
        $users1= User::whereIn('id',$likedowners)->get();
            
    

 if($followerPosts){
    
             return view('post.index', compact('posts','user','users','followerPosts','users1'));
 
         }else{
            
             return view('post.index', compact('posts','user','users','users1'));
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
// public function likedAccounts(User $user)
// {
//     dd($user);
//     // Get the liked accounts for the specified user
//     $likedAccounts = $user->likedAccounts();

//     // Return the view with the liked accounts
//     return view('liked_accounts', compact('likedAccounts'));
// }

// public function commonFriends(User $user)
// {
//     // Get the common friends for the specified user
//     $commonFriends = $user->commonFriends();

//     // Return the view with the common friends
//     return view('common_friends', compact('commonFriends'));
// }
// }
                                                                                                            