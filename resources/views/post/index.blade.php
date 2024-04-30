@extends('layouts.app')  
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           
            <h1>All Tweets</h1> 
           
                <!-- Sorted posts -->
            
            <h4 style="background-color: yellow">SORT with these methods</h4>
            <a style="background-color: rgb(212, 212, 158)" href="{{ route('posts.sort', ['sort' => 'newest']) }}">1:Newest</a><hr>
            <a style="background-color: rgb(212, 212, 158)" href="{{ route('posts.sort', ['sort' => 'likeable']) }}">2:Most Likeable</a><hr>
            <a style="background-color: rgb(212, 212, 158)" href="{{ route('posts.sort', ['sort' => 'commentable']) }}">3:Most Commentable</a>
              
             @guest
            <div class="alert alert-info">
                <strong>Notice!</strong> Login first for create New Tweet
                @endguest

            
            @if (session()->has('message'))
            <div  style="font-size: 40px; color:rgb(10, 54, 231);text-align:left">
                {{ session('message') }}
            </div>
            @endif
            @if (session()->has('error'))
            <div  style="font-size: 60px; background-color: rgb(226, 50, 85);text-align:center" >
                {{ session('error') }}
            </div>
            @endif
        </div>


        @if(auth()->check())
         <a href="{{ route('post.create') }}" class="btn btn-success" style="font-size:30px">NewTweet</a>
            @endif


            <table class="table table-bordered">
                <thead style="text-align:center">
                    <th style="text-align:center">user</th>
                  
                    <th style="text-align:center">title</th>
                    <th style="text-align:center">image</th>
                    <th style="text-align:center">video</th>
                    <th  width="250px" style="color:blue">comments</th>
                    <th  width="20px">like</th>
                    <th  width="20px">dislike</th>
                    <th style="color: red" width="150px">Reports</th>
                    <th style="text-align:center">retweets</th>
                    <th style="text-align:center">Profiles</th>
                    <th style="text-align:center">FollowMetod</th>
                    
                    
                    
                </thead>
                <tbody>
                @foreach($posts as $post)
                
         
                <tr>
                    <td style="text-align:center">{{ $post->user->name }}</td>
                    
                    <td style="text-align:center">{{ $post->title }}</td>
                    <td>
        @if($post->image)
                     <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}"></td>
        @else
                       <div> no image</div>
        @endif
                    </td>
                    <td>
        @if($post->video)
                        <video width="200" height="150" controls>
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    </video>

                </td>
         @else
                       <div> no video</div>
         @endif
         <td> @foreach($post->comments as $comment)
            {{$comment->body}}<hr>
            @endforeach</td>
         <td>  <form action="{{ route('like.post', $post->id) }}"
            method="post">
            @csrf
            <button
                class="{{ $post->liked() ? 'bg-blue-600' : '' }} px-2 py-1 text-black bg-gray-200">
                like 
            </button>
        </form>
</td>
         <td> <form action="{{ route('unlike.post', $post->id) }}"
            method="post">
         @csrf
        <button
         class="{{ $post->liked() ? 'block' : 'hidden'  }} px-2 py-1 text-black bg-red-200">
        unlike
        </button>
        </form></td>
         <td>
            @auth
              <form action="{{route('post.report',$post->id)}}" method="POST">
                  @csrf
                  <input type="hidden"  name="post_id" value="{{$post->id}}" />
                    <input style="color: red" type="submit" value="ReportPost">
                  </form>
           @else
                  <a href="{{route('login')}}">login</a> then you can submit report

          @endauth</td>
         <td>
            @auth
              <form action="{{ route('retweet.store', $post->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-primary">Retweet</button>
                  </form>
           @else
                  <a href="{{route('login')}}">login</a> then you can retweet

          @endauth
</td>
                            </td>
                        
                        
                        
                    
                    <td 
                    
                    
                        
                   
                    style="text-align:center"> <a href="{{ route('profile.index',$post->user_id)}}">profile</a></td> 
                    
                    <td >
                      
                    
                        <form action="{{ route('follow',$post->user_id) }}" method="POST">
                            @csrf
                            <button type="submit">Follow</button>
                        </form><br><form action="{{ route('unfollow',$post->user_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Unfollow</button>
                        </form>
                    </td> 
                  
                    
              
                
                @endforeach
                
          
                </tbody>
   
            </table>
           
        </div>
    </div>
</div>

@endsection 