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
         <a href="{{ route('post.create') }}" class="btn btn-success" style="font-size:30px">NewTweet</a>
            <a  href="{{ route('profile.index')}}" class="btn btn-primary" style="font-size:30px"><span style='font-size:30px;'>&#11088;</span>Profile</a>
            <table class="table table-bordered">
                <thead style="text-align:center">
                    <th style="text-align:center">id</th>
                    <th style="text-align:center">title</th>
                    <th style="text-align:center">image</th>
                    <th style="text-align:center">video</th>
                    <th style="text-align:center">show</th>
                    
                    
                </thead>
                <tbody>
                @foreach($posts as $post)
               
                <tr>
                    <td style="text-align:center">{{ $post->id }}</td>
                    <td style="text-align:center">{{ $post->title }}</td>
                    <td>
        @if($post->image)
                     <img width="60" height="40" controls src="{{ asset('storage/' . $post->image) }}"></td>
        @else
                       <div> no image</div>
        @endif
                    
                    <td>
        @if($post->video)
                        <video width="100" height="60" controls>
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    </video>


         @else
                       <div> no video</div>
         @endif
                            </td>
                        
                        
                        
                    
                    <td style="text-align:center"> <a href="/posts/{{$post->id}}">show tweet</a></td> 
                    
                    
                @endforeach
                
          
                </tbody>
   
            </table>
           
        </div>
    </div>
</div>

@endsection 