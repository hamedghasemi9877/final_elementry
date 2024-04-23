<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Conner\Likeable\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProfileRequest;

class ProfileController extends Controller
{
  public function __constract(){

    return $this->middleware('auth');
    }




    public function index()
    {
        
        $posts = auth()->user()->posts;
        //In order to avoid the N+1 problem
        $comments = Post::with('comments')->get();
        $posts = Post::withCount(['likes', 'comments'])->get(); 
     
        return view('profile.index',compact('posts','comments'));

    }


    
    public function create()
    {
        return view('post.create');
    }

    public function store(StoreProfileRequest  $request)
    {
    
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
       
        $post['user_id'] = auth()->user()->id;
      
        $post->save();
        
        
        return redirect('/profile')->with('message','A new tweet has been registered');
    }






    public function edit(Post $post)
    {

        return view('post.edit', compact('post'))->with('message','Your command has been executed!');
    }







    public function update(Request $request,post $post)
    {
       
  $post->update($request->all());

      
        return redirect('/profile')->with('message','Your command has been executed!');
    }





    public function destroy(Post $post)
    {
       
         $post->delete();

      
        return redirect()->back()->with('message','Your tweet has been deleted!');
    }

}
