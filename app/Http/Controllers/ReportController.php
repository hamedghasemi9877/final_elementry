<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller{  


    public function reportPost(Request $request,$post_id)
    {
        
        $post = Post::find($post_id);
      
        $data = $post->reports()->where('user_id', auth()->id());
        // checking that user can once reporting post not more
        if ($data->exists()) {
            return redirect()->back()->with('error','You have already reported this post');
        }
    
        
        $report = new Report();
       
        $report->post_id = $post->id;
        $report->user_id = auth()->id(); 
        $report->save();
      
        
        if ($post->reports()->count() >= 5) {
            $post->reports()->delete();
            $post->delete();
            return redirect('/')->with('message','Post reported and deleted successfully');
        }
    
        return redirect()->back()->with('message','Post reported successfully');
    }}
    

