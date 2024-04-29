<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function follow(Post $post,$user_id)
    {
          
      
   
    $user = Follower::findOrFail($post);
    
    $follower_id = auth()->id();
   

    // Check if the user is already being followed
    $existingFollow = Follower::where('user_id', $follower_id)
                              ->where('following_id', $user_id)
                              ->exists();

    if (!$existingFollow) {
        // Create a new follower record
        Follower::create([
            'user_id' => $follower_id,
            'following_id' => $user_id,
        ]);
    }
          
            return back()->with('message', 'You are now following ' );
        
            
        
    }
    
        public function unfollow(Post $post,$user_id)
        {
            
    $user = Follower::findOrFail($post);
    
    $follower_id = auth()->id();
   

    // Check if the user is already being followed
    $existingFollow1 = Follower::where('user_id', $follower_id)
                              ->where('following_id', $user_id)
                              ->first();

              if ($existingFollow1) {
                 $existingFollow1->delete();
            return back()->with('message', 'You have unfollowed ' );
        }
        return back()->with('error', 'You are not follow' );
}}

