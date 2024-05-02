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

{{-- information of owner and permission status --}}
       <h1 style="background-color: chartreuse">welcome to page of:<u>{{$user->name}}</u></h1><br>
       
       @if(auth()->check()&& auth()->user()->id===$user->id)

                <div>
                        <form action="{{ route('users.visibility.update', $user->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" 
                                
                            value="{{$user->id}}">
                            <label for="visibility">Visibility:</label>
                            <select name="visibility" id="visibility">
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                            <button type="submit">change</button>
                        </form>
                        <p style="color: blue">You are only allowed to change your status</p>
                </div>
                
           @endif
           
       <h2 style="color: blue"><img src="https://cdn-icons-png.flaticon.com/128/11079/11079218.png" loading="lazy" alt="Privacy " title="Privacy " width="64" height="64"><u>{{$visibility}}</u></h2> 
@guest
       <a href="" class="btn btn-success" style="float: left">FOLLOW</a>
@endguest
       <a href="/" class="btn btn-info" style="float: left">home</a><br><br>
      
       <a href="{{ route('post.create') }}" class="btn btn-success" style="font-size:30px">NewTweet</a>
        
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
                       
                       
        
                <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}"></td>

               </td>
               <td>
                   
                   <video width="200" height="150" controls>
                       <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
               </video>

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
{{-- @foreach ($users as $user)
<tr>
    <td> TotalPosts:{{ $user->posts_count }}</td><br>
    <td class="text-center">Total Comments{{ $user->comments_count }}</td>
</tr>
@endforeach --}}



 
{{-- 
    <h2>Followers<h2>Followers Count: {{ $followers->count() }}</h2></h2>
    <ul>
        @foreach($followers as $follower)
            <li>{{ $follower->name }}</li>
        @endforeach
    </ul> --}}

    
@endsection




