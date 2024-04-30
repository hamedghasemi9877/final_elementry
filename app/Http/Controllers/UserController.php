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
    
}
