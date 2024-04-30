<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Conner\Likeable\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  
    public function index(User $user)
    {
        
            // Get the authenticated user
            $authUser = auth()->user();
        
            // Retrieve posts from the specified user
            $posts = $user->posts()->withCount('likes', 'comments')->get();
        
            // Check if the authenticated user follows the specified user
            $isFollowing = $authUser->isFollowing($user);
        
            // Retrieve posts from users whom the authenticated user is following
            $followingPosts = collect();
            if ($isFollowing) {
                $followingPosts = $authUser->following()->with('posts')->get()->pluck('posts')->flatten();
            }
        
            // Return the view with the posts and following posts
            return view('profile.index', compact('posts', 'user', 'followingPosts', 'authUser', 'isFollowing'));
        }


    
    public function create()
    {
        return view('post.create');
    }

    public function store(StoreProfileRequest  $request)
    {
        
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
