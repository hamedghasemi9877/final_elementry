<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Follower;
use Conner\Likeable\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller{

   

     public function index(Request $request, $sort='newest') {

        $user = auth()->user();
        // just for users that authenticated-----------
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
        //   PrivateUsers------------
          $PrivateUsers = User::where('visibility','private' )->get();


        //   PublicUsers-------------
          $PublicUsers  = User::where('visibility','public' )->get();
          

       
        // implement users with same following_id------------
        $userIdsWithSameFollowingId = Follower::selectRaw('GROUP_CONCAT(user_id) as user_ids')
        ->groupBy('following_id')
        ->havingRaw('COUNT(*) > 1')
        ->pluck('user_ids');
        $usersWithSameFollowingId = User::whereIn('id', $userIdsWithSameFollowingId)->get();


        // user followers--------
        $followers_id = $user->following->pluck('user_id');

        //  user followings---------------
        $followings_id = $user->followers->pluck('following_id');
        //   or=>$following_id =Follower::where('user_id', $user->id)->pluck('following_id');
          


        // the post of followings-----------
        $followerPosts = Post::whereIn('user_id', $followings_id)->get();
         

        // Suggested Users to Follow with like system:
        // the ids of posts that user like them------------
        $postslikes_id = Like::where('user_id',$user->id)->pluck('likeable_id');
      

        //the user_id  of posts----------
        $likedOwners= Post::whereIn('id', $postslikes_id)->pluck('user_id');
         

        // owners---------
        $users1= User::whereIn('id',$likedOwners)->get();


        /*------------------------------
        if A follow B & B follow C
        suggestion to A that follow C
        */
     
      // Suggested Users to Follow with follow system:
$followingsSuggest = $user->followers->pluck('following_id');
$suggestedUsers = [];

foreach ($followingsSuggest as $followingId) {
    // Retrieve the user object corresponding to the following_id
    $followingUser = User::find($followingId);

    // Check if the user exists and has followers
    if ($followingUser && $followingUser->followers->isNotEmpty()) {
        // Retrieve the following_ids of the followers of the following user
        $followersOfFollowingUser = $followingUser->followers->pluck('following_id')->toArray();

        // Add the following_ids of the followers of the following user to the suggested users array
        $suggestedUsers = array_merge($suggestedUsers, $followersOfFollowingUser);
    }
}

// Remove duplicates and the user's own id from the suggested users array
$suggestedUsers = array_diff(array_unique($suggestedUsers), [$user->id]);

// Retrieve the user objects corresponding to the suggested user ids
$suggestedUsers = User::whereIn('id', $suggestedUsers)->get();



        // If the following user has a post
   if($followerPosts){
    
       return view('post.index', compact('posts','user','followings_id','PrivateUsers','PublicUsers','followerPosts','users1','usersWithSameFollowingId','suggestedUsers'));}
   
   
     else{// If the following user doesnt have a post
           
        
       return view('post.index', compact('posts','user','users','users1'));
 }
        }
 
// if user not exists-----
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

 $users = User::where('visibility','public' )->get();

 return view('post.index', compact('posts','users'));
         }}
