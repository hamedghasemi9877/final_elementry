@extends('layouts.app')  
@section('content')
@if(auth()->check())
<div class="btn btn-info" style="float: right"><a href="{{ route('profile.index',$user->id)}}">your profile</a> </div><br><br>
@endif



{{-- Suggestions --}}
@auth
<p1 style="background-color: rgb(195, 118, 134)">Suggestions for you:</p1><br>

@foreach ($users1 as $user1)
@if(auth()->user()->id!==$user1->id)
@if(!$user1->isFollowing($user1->id))
<p1>{{$user1->name}}<form action="{{ route('follow',$user1->id) }}" method="POST">
    @csrf
    <button type="submit">Follow</button>
</form></p1> 
@endif 
@endif 
@endforeach 
@endauth

{{--  --}}


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
            
            <h class="btn btn-info">The posts of public users and your followers</h> 
           
                <!-- Sorted posts -->
            
            <h4 style="color: rgb(255, 0, 0)">SORT with these methods</h4>
            <a style="color: rgb(9, 255, 0)" href="{{ route('posts.sort', ['sort' => 'newest']) }}">1:Newest</a><hr>
            <a style="color:rgb(9, 255, 0)" href="{{ route('posts.sort', ['sort' => 'likeable']) }}">2:Most Likeable</a><hr>
            <a style="color: rgb(9, 255, 0)" href="{{ route('posts.sort', ['sort' => 'commentable']) }}">3:Most Commentable</a>
              
             @guest
            <div class="alert alert-info">
                <strong>Notice!</strong> Login first for create New Tweet
                @endguest

            
{{-- all users --}}

@foreach($posts as $post)
@if(auth()->check()&& auth()->user()->id!==$user->id)
<p>   {{$post->user->name}} <form action="{{ route('follow',$post->user_id) }}" method="POST">
    @csrf
    <button type="submit">Follow</button>
</form><hr>  </p>
@endif
@endforeach

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

            <h2>public posts:</h2>
            <table class="table table-bordered">
                <thead style="text-align:center">
                
                  
                   
                    <th style="text-align:center">title</th>
                    <th style="text-align:center">image</th>
                    <th style="text-align:center">video</th>
                    <th  width="250px" style="color:blue">comments</th>
                    <th  width="10px">like</th>
                    <th style="color: red" width="30px">Reports</th>
                    <th style="text-align:center">retweets</th>
                    <th style="text-align:center">Profiles</th>
                    <th style="text-align:center">FollowMetod</th>
                    
                    
                    
                </thead>
                <tbody>
                  
                @foreach($posts as $post)
               @if($post->user->visibility==='public')
               
                <tr>
                   
                    
                    
                    <td style="text-align:center">{{ $post->title }}</td>
                   
                    <td style="text-align:center">
    @if($post->image!==null)
                     <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}"></td>
   
        
    @else
                 no image
    @endif
                    </td>
                    <td style="text-align:center">
    @if($post->video!==null)              
                        <video width="200" height="150" controls>
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    </video>
    @else
                no video
    @endif
                </td>
        
         <td style="text-align:center">
            <form method="post" action="{{route('posts.comments.store')}}">       
                <input type="hidden"  name="post_id" value="{{$post->id}}" />
                    @csrf
                    <input name="body" type="text" >
                    <input type="submit" class="btn btn-success" />
            </form><br>
            
            
            @foreach($post->comments as $comment)
            {{$comment->body}}<hr>
            @endforeach
              
                
            </td>
         <td style="text-align:center">  <form action="{{ route('like.post', $post->id) }}"
            method="post">
            @csrf
            <button>
                like 
            </button>
        </form><br><form action="{{ route('unlike.post', $post->id) }}"
            method="post">
         @csrf
        <button>unlike
        </button>
        </form>
</td>
        
         <td style="text-align:center">
            
              <form action="{{route('post.report',$post->id)}}" method="POST">
                  @csrf
                  <input type="hidden"  name="post_id" value="{{$post->id}}" />
                    <input style="color: red" type="submit" value="ReportPost">
                  </form>
          
         </td>
         <td>
           
           
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Share or Retweet Post') }}</div>
        
                            <div class="card-body">
                                <form action="{{ route('retweet.store',  $post->id) }}" method="POST">
                                    @csrf
        
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Share or Retweet') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
          
</td>
                            </td>
                        
                        
                        
                    
                    <td 
                    
                    
                        
                   
                    style="text-align:center"> <a href="{{ route('profile.index',$post->user_id)}}">profile</a></td> 
                    
                    <td style="text-align:center">
                      
                    
                        <form action="{{ route('follow',$post->user_id) }}" method="POST">
                            @csrf
                            <button type="submit">Follow</button>
                        </form><br><form action="{{ route('unfollow',$post->user_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Unfollow</button>
                        </form>
                    </td> 
                  
                    
              
              
             
                @endif
                @endforeach
         
                </tbody>
   
            </table>
           
        </div>
    </div>
</div>
@auth
<h2>posts of your Followings:</h2>

    
    <table class="table table-bordered">
        <thead style="text-align:center">
        
          
            <th style="text-align:center">user</th>
            <th style="text-align:center">title</th>
            <th style="text-align:center">image</th>
            <th style="text-align:center">video</th>
            <th  width="250px" style="color:blue">comments</th>
            <th  width="10px">like</th>
            <th style="color: red" width="30px">Reports</th>
            <th style="text-align:center">retweets</th>
            <th style="text-align:center">Profiles</th>
            <th style="text-align:center">FollowMetod</th>
            
            
            
        </thead>
        <tbody>
          @if(auth()->check())
        @foreach ($followerPosts as $post)
       
       
        <tr>
           
            
            <td style="text-align:center">{{ $post->user->name }}</td>
            <td style="text-align:center">{{ $post->title }}</td>
            <td style="text-align:center">
               
               
@if($post->image!==null)
                <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}"></td>

   
@else
            no image
@endif
            </td>
            <td style="text-align:center">
                
@if($post->video!==null)              
                <video width="200" height="150" controls>
                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
            </video>
@else
        no video
@endif
        </td>

 <td>
    <form method="post" action="{{route('posts.comments.store')}}">       
        <input type="hidden"  name="post_id" value="{{$post->id}}" />
            @csrf
            <input name="body" type="text" >
            <input type="submit" class="btn btn-success" />
    </form><br>
    
    
    @foreach($post->comments as $comment)
    {{$comment->body}}<hr>
    @endforeach
      
        
    </td>
 <td style="text-align:center">  <form action="{{ route('like.post', $post->id) }}"
    method="post">
    @csrf
    <button>
        like 
    </button>
</form><br><form action="{{ route('unlike.post', $post->id) }}"
    method="post">
 @csrf
<button>unlike
</button>
</form>
</td>

 <td style="text-align:center">
    
      <form action="{{route('post.report',$post->id)}}" method="POST">
          @csrf
          <input type="hidden"  name="post_id" value="{{$post->id}}" />
            <input style="color: red" type="submit" value="ReportPost">
          </form>
  
 </td>
 <td style="text-align:center">
   
   
      <form action="{{ route('retweet.store', $post->id) }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-primary">Retweet</button>
          </form>
  
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
 @endif
        </tbody>

    </table>
    
@endauth





@endsection 