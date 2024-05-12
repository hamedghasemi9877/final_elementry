@extends('layouts.app')  
@section('content')


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



<a href="/" class="btn btn-info" style="float: right">Home</a><br>
<h1>Only public posts and posts of people you have already followed</h1>

@if ($posts->isEmpty())
    <p>No posts found for the hashtag.</p>
@else
    <ul>
      
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
                <div style="text-align: center">
                  
                 
                        
                            <form action="{{ route('retweet.store',  $post->id) }}" method="POST">
                                @csrf
    
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Retweet') }}
                                </button>
                            </form>
                        
                  
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
              
                
          
          
         
       
            @endforeach
    </ul>
@endif

















@endsection