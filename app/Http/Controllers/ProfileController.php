<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Follower;
use Conner\Likeable\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProfileRequest;

class ProfileController extends Controller
{

    public function index(User $user){
      
      
          $posts = $user->posts()->withCount(['likes', 'comments'])->get();
                   // or
         // $posts = Post::withCount(['likes', 'comments'])->where('user_id',$user->id)->get();
       

                   // all users with public status---------
        $users = User::where('visibility','public')->get();

                   // user visibility------------
           $visibility = $user->visibility;

                   // followings-------
        $followings_id = $user->following->pluck('following_id');
        $followingNames = User::whereIn('id', $followings_id)->pluck('name')->toArray();
        $followingNames = collect($followingNames);
        
                   // followers--------
          $followers_id = $user->followers->pluck('user_id');
          $followerNames = User::whereIn('id', $followers_id)->pluck('name')->toArray();
          $followerNames = collect($followerNames);
        
            return view('profile.index', compact('posts','user','users','visibility','followingNames','followerNames'));
        }

    
    public function create()
    {
        $hashtags = Hashtag::all();
        return view('post.create',compact('hashtags'));
    }

    public function store(StoreProfileRequest  $request){


        $imagePath = $request->file('image') ? Storage::putFile('images', $request->file('image')) : null;
        $videoPath = $request->file('video') ? Storage::putFile('videos', $request->file('video')) : null;
       
    //  $url = Storage::url($path);
    $data = $request->merge([
       'image'=>$imagePath
    ]);
   
    $data = $request->merge([
       'video'=>$videoPath
    ]);
    
          // or....


        // if($request->has('image')){
        //     //    file with extension
        //     $image = $request->file('image')->getClientOriginalName();

        // //    file name
        //     $image_name =pathinfo($image,PATHINFO_FILENAME);
        //     // dd($image_name);

        // //  extension
        //     $image_ext = $request->file('image')->getClientOriginalExtension();
        //     // dd($image_ext);
            
        //     // change time format
        //     $timestamp = Carbon::now()->format('Y/m/d_H:i:s');

        //     // store
        //     $image_to_store = $image_name.'_'.$timestamp .'.'.$image_ext;
        //     // dd($image_to_store);

        //     // upload
        //    $path = $request->file('image')->storeAs('public/images',$image_to_store);
           
        // }else{
        //     $image_to_store = 'noimage.jpg';

        // }
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->image = $request->input('image');
        $post->video = $request->input('video');
       
        $post['user_id'] = auth()->user()->id;
      
        $post->save();
        // Extract hashtags from the input
    $hashtags = explode(',', $request->input('name'));

    // Save each hashtag to the database 
    foreach ($hashtags as $tag) {
        $tag = trim($tag); 
        if ($tag !== '') {
        $hashtag = Hashtag::Create(['name' => $tag]);
        // related to pivot table
        $post->hashtags()->attach($hashtag);
    }}
        
        return redirect('/')->with('message','A new tweet has been registered');
    }






    public function edit(Post $post)
    {

        return view('post.edit', compact('post'))->with('message','Your command has been executed!');
    }







    public function update(Request $request,$id)
    {
       $request->validate([

        'title' => 'required',
        'body' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:300', //for example size:1999 and just validate jpeg,png,jpg file
        'video' => 'mimes:mp4|max:3000'

       ]);
       $post = Post::findOrFail($id);

       // Check if new image file is uploaded
       if ($request->hasFile('image')) {
        if ($post->image) {
            Storage::delete($post->image);
        }
           
           $imagePath = Storage::putFile('images', $request->file('image'));
           // Update image field with new path
          
           $post->image = $imagePath;
       }
   
       // Check if new video file is uploaded
       if ($request->hasFile('video')) {
        if ($post->video) {
            Storage::delete($post->video);
        }
          
           $videoPath = Storage::putFile('videos', $request->file('video'));
           // Update video field with new path
           $post->video = $videoPath;
       }
   
       // Update other fields
       $post->title = $request->input('title');
       $post->body = $request->input('body');
   
       // Save changes to the database
       $post->save();
   
    
      
        return redirect(route('profile.index',$post->user_id))->with('message','Your command has been executed!');
    }





    public function destroy(Post $post)
    {
       
         $post->delete();

      
        return redirect()->back()->with('message','Your tweet has been deleted!');
    }

}
