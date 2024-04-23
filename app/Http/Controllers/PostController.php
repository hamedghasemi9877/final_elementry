<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
// public function __constract(){
    
// return $this->middleware('auth');


// }
   

    public function index(Request $request, $sort='newest') {
        // dd($sort);
        if($sort=='newest'){
            $posts = Post::withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();
        }
        if($sort=='likeable'){
            $posts = Post::withCount(['likes', 'comments'])
            ->orderBy('likes_count', 'desc')
            ->get();
        }
        if($sort=='commentable'){
            $posts = Post::withCount(['likes', 'comments'])
            ->orderBy('comments_count', 'desc')
            ->get();
        }
     
                     
         return view('post.index', compact('posts'));
   
}





    public function show(Request $request,$id) {
       
        
        
         $post = Post::find($id);
        
      
         return view('post.show',compact('post'));
       

        
}


  
}