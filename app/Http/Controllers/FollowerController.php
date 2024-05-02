<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
 
  public function follow( User $user)
  {
    
      $authUser = auth()->user();
      if($authUser==$user){
        return redirect()->back()->with('error', 'impossible!!!');

      }
      if (Follower::where('user_id', $authUser->id)->where('following_id', $user->id)->exists()) {
        
        return redirect()->back()->with('error', 'You are already following this user.');
        }
      if (!$authUser->isFollowing($user->id)) {
         
        $data = new Follower();
       
       
        $data->user_id = auth()->id(); 
       
        $data->following_id =$user->id; 

        $data->save();
        return redirect()->back()->with('message','submited!!');
      }

     
  }


  public function unfollow(User $user)
  {
      
    $authUser = auth()->user();

    if($authUser==$user){
      return redirect()->back()->with('error', 'impossible!!!');
    }
    $followerRecord = Follower::where('user_id', $authUser->id)
                               ->where('following_id', $user->id)
                               ->first();

   
    if ($followerRecord) {
       
        $followerRecord->delete();
    }

   
    return redirect()->back()->with('message','submited!!');
 
}
}