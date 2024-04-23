<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
  public function __constract(){

    return $this->middleware('auth');
    }


    
    public function create()
    {
      
      $posts =Post::with('comments')->get();
     
        return view('comment.create',compact('posts'));
   
    }




    public function store(StoreCommentRequest $request)
    { 
      
if(Auth::check()){ 
 
  $data = Post::where('id',$request->post_id)->first();
  
      Comment::create([
        'user_id' =>auth()->user()->id,
        'post_id' =>$data->id,
       'body' =>$request->body
      ]);
      
        return redirect()->back()->with('message','Your Idea Submited!');
      }
        else

        {

          return  redirect(route('login'))->with('error','first log in!!!!');

        }
    }




    public function show(Request $request,$id)
    { 
      
      $comments =Comment::all();
  $posts = Post::find($id);
    
       
   
        return view('comment.show',compact('comments','posts'));
    }
    public function destroy(Comment $comment)
    {
  
         $comment->delete();

      
        return redirect()->back()->with('message','Your command has been executed!');
    }
}
