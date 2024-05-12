<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller{


    
    public function likePost($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id!=$post->user_id){
        $post->like();
        $post->save();

        return redirect()->back()->with('message','Post Like successfully!');
   }
   return redirect()->back()->with('error','The post belongs to you. Impossible!');
}

    public function unlikePost($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id!=$post->user_id){
        $post->unlike();
        $post->save();
        
        return redirect()->back()->with('message','Post unliked!');
    }
    return redirect()->back()->with('error','The post belongs to you. Impossible!');
}
}
