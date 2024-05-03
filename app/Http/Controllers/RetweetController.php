<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Retweet;
use Illuminate\Http\Request;

class RetweetController extends Controller{



    public function __constract(){
    
        return $this->middleware('auth');
       
       
        }

    public function retweet(Request $request, $post_id)
    {


    $post = Post::findOrFail($post_id);

    $existingRetweet = Retweet::where('user_id', auth()->id())->where('post_id', $post->id)->first();

    if ($existingRetweet) {
       
        return redirect()->back()->with('error', 'You have already retweeted this post.');
    }

   
    $retweet = new Retweet();
    $retweet->user_id = auth()->id();
    $retweet->post_id = $post->id;
    $retweet->save();
    $post = Post::find($post_id);
    $post->increment('retweet_count');
    
    return redirect()->back()->with('message', 'You have retweeted the post.');
}




public function delete($id)
{

    $retweet = Retweet::findOrFail($id);

  
    if ($retweet->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

   
    $retweet->delete();

    return redirect()->back()->with('success', 'Retweet deleted successfully.');
}

}