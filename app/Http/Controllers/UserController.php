<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Visibility(Request $request,$user_id)
    {
       
        if ($request->post_id !== $user_id) {
            return back()->with('error', 'You are not allowed to change other users status!');
        }

       $post = User::find($request->post_id);
    //   dd($post);
        $post->visibility = $request->visibility;
        // dd($post);
        $post->save();

        return back()->with('message', 'Post visibility updated successfully.');
    }
    
    public function likedAccounts(User $user)
    {
        // Get the liked accounts for the specified user
        $likedAccounts = $user->likedAccounts();

        // Return the view with the liked accounts
        return view('liked_accounts', compact('likedAccounts'));
    }

    public function commonFriends(User $user)
    {
        // Get the common friends for the specified user
        $commonFriends = $user->commonFriends();

        // Return the view with the common friends
        return view('common_friends', compact('commonFriends'));
    }


}
