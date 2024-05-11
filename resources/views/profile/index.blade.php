@extends('layouts.app')
@section('content')

@if (session()->has('message'))
<div  style="font-size: 40px;color:rgb(123, 230, 123) ">
  {{ session('message') }}
</div>
@endif
@if (session()->has('error'))
<div  style="font-size: 40px;color:rgb(225, 73, 111) ">
  {{ session('error') }}
</div>
@endif

@guest
<h1 style="background-color: chartreuse">welcome to page of:<u>{{$user->name}}</u></h1><br>
@endguest
@if(auth()->check()&& auth()->user()->id!==$user->id)
@if($user->visibility=='private')
<p style="background-color: rgb(231, 90, 118)">you should first follow then you can see  tweets in the home page </p> 
@endif
<h1 style="background-color: chartreuse">welcome to page of:<u>{{$user->name}}</u></h1><br>
@endif

@if(auth()->check()&& auth()->user()->id===$user->id)
<h1 style="background-color: chartreuse">welcome:<u>{{$user->name}}</u></h1><br>
         
    @endif

{{-- information of owner and permission status --}}
@if(auth()->check()&& auth()->user()->id===$user->id)

<h1 style="background-color: rgb(36, 217, 202)">your followings:{{$followingNames->count()}}</h1> 
@foreach($followingNames as $name)
    <u>{{ $name }}</u><br>
@endforeach<hr>
<h1 style="background-color: rgb(36, 217, 202)">your followers:{{$followerNames->count()}}</h1>
@foreach($followerNames as $name)
    <u>{{ $name }}</u><br>
@endforeach

@endif
        
       <h2 style="color: blue"><img src="https://cdn-icons-png.flaticon.com/128/11079/11079218.png" loading="lazy" alt="Privacy " title="Privacy " width="64" height="64"><u>{{$visibility}}</u></h2> 
@guest
       <a href="" class="btn btn-success" style="float: left">FOLLOW</a>
@endguest

       <a href="/" class="btn btn-info" style="float: left">home</a><br><br>
 @if(auth()->check()&& auth()->user()->id===$user->id)
 <div>
    <form action="{{ route('users.visibility.update', $user->id) }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" 
            
        value="{{$user->id}}">
        <label for="visibility">Visibility:</label>
        <select name="visibility" id="visibility" value="{{$user->visibility}}">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
        <button type="submit">change</button>
    </form>
    <p style="color: blue">You are only allowed to change your status</p>
</div>

 @if($user->visibility=='private')
<p style="background-color: crimson"> No one on the public page can see your tweets  </p> 
@endif
 @if($user->visibility=='public')
<p style="background-color: rgb(27, 220, 20)"> all people on the public page can see your tweets  </p> 
@endif
       <a href="{{ route('post.create') }}" class="btn btn-success" style="font-size:30px">NewTweet</a>
@endif
{{--  --}}


    @auth
        @if(auth()->user()->id !== $user->id)
            @if(!(auth()->user()->isFollowing($user->id)))
                <form action="{{ route('follow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit">Follow</button>
                </form>
            @endif
            @endif
            
            @if(auth()->user()->id !== $user->id)
            @if((auth()->user()->isFollowing($user->id)))
                <form action="{{ route('unfollow', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Unfollow</button>
                </form>
               
        @endif
        @endif
    @endauth

{{--  --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

{{-- change visibility[public or private] --}}

               
          
{{--  --}}
           

{{-- all tweets { the tweets of public users and followers} --}}
            <h1 style="background-color: rgb(69, 75, 159)">Tweets</h1>
            <div class="container">
                <div class="row justify-content-center">
            <table class="table table-bordered">
          
                <thead>
                    <th >title</th>
                    <th >body</th>
                    <th >image</th>
                    <th >video</th>
                    <th  width="5px">total likes</th>
                    <th  width="5px">total comments</th>
                    <th >comments</th>
                    <th >edit</th>
                    <th>delete tweets</th>
                    
                       
                  
                </thead>
                
                <tbody>
            


                    @foreach ($posts as $post)
    @if($user->visibility === 'public')
        <tr>
            <td style="color:rgb(69, 40, 255)" >{{ $post->title }}</td>
            <td > {{ $post->body }}</td>
            <td>
                       
                       
@if($post->image!==null)
                <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}"></td>
@else
              no image
@endif
               </td>
               <td>
@if($post->video!==null)                   
                   <video width="200" height="150" controls>
                       <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
               </video>
@else
               no video
 @endif
           </td>
            <td>{{ $post->likes_count }}</td>
            <td> {{ $post->comments_count }}</td>

            <td>
                @foreach($post->comments as $comment)
                    {{$comment->body}}
                  
                    @if(auth()->check() && auth()->user()->id === $user->id)
                       <form action="/comments/{{$comment->id}}/delete" method="POST">
                            @csrf
                            @method('delete')
                            <input style="color: rgb(222, 78, 78)" type="submit" value="delete">
                        </form>
                    @endif
                    <hr>
                @endforeach
            </td>
       
    @endif

@if(auth()->check() && $post->user_id === auth()->user()->id)
                    <td>
                        <a href="/posts/{{$post->id}}/edit">EDIT</a></td>
                    <td ><form action="/posts/{{$post->id}}/delete" method="POST">
                        @csrf
                        @method('delete')
                          <input style="color: red" type="submit" value="Deletetweet">
                        </form> </td> 
                   
                @endif 
                  
                </tr>
                @endforeach
                </tbody>
            
   
            </table>      
        </div>
        </div>
            
           
        </div>
    </div>
</div>

@endsection




