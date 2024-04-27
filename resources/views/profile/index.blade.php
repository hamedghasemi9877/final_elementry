@extends('layouts.app')
@section('content')

@if (session()->has('message'))
<div  style="font-size: 40px;color:rgb(123, 230, 123) ">
  {{ session('message') }}
</div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <a href="{{ route('post.create') }}" class="btn btn-success" style="float: right">New Tweet</a>
            <a href="/" class="btn btn-info" style="float: right">home</a><br><br>


            @if(count($posts)>0)
            <h1 style="background-color: rgb(69, 75, 159)">Your Tweets</h1>
            <div class="container">
                <div class="row justify-content-center">
            <table class="table table-bordered">
          
                <thead>
                    <th >title</th>
                    <th >body</th>
                    <th >comments</th>
                    <th >edit</th>
                    
                    <th>delete tweets</th>
                    
                       
                  
                </thead>
                
                <tbody>
            


                @foreach($posts as $post)
                <tr>
                    <td style="color:rgb(69, 40, 255)" >{{ $post->title }}</td>
                    <td > {{ $post->body }}</td>
                    <td >@foreach($post->comments as $comment)
                        {{$comment->body}}
                        
                        <form action="/comments/{{$comment->id}}/delete" method="POST">
                            @csrf
                            @method('delete')
                              <input style="color: rgb(222, 78, 78)" type="submit" value="delete">
                            </form>
                        
                        
                        <hr>
                        vv @endforeach</td>
                    <td><a href="/posts/{{$post->id}}/edit">EDIT</a></td>
                    <td ><form action="/posts/{{$post->id}}/delete" method="POST">
                        @csrf
                        @method('delete')
                          <input style="color: red" type="submit" value="DeletePost">
                        </form> </td>
                   
                  
                </tr>
                @endforeach
                </tbody>
            
   
            </table>
        </div>
        </div>
            @else
            <h1 style="color: black">you dont have any tweet!<br><p> <a href="/">home</a> </p></h1>
            @endif
           
        </div>
    </div>
</div>
{{-- @foreach ($users as $user)
<tr>
    <td> TotalPosts:{{ $user->posts_count }}</td><br>
    <td class="text-center">Total Comments{{ $user->comments_count }}</td>
</tr>
@endforeach --}}


<div class="container">
    <div class="row justify-content-center">
<h1 style="background-color: rgb(143, 146, 181)">Profile Details</h1>
            <table class="table table-bordered">
                <thead>
                    <th  width="5px">id</th>
                    <th width="5px">title</th>
                    <th  width="5px">total likes</th>
                    <th  width="5px">total comments</th>
                    
              
                       
                  
                </thead>
                
                <tbody>
                  

                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->likes_count }}</td>
                    <td> {{ $post->comments_count }}</td>
                   
                  
                </tr>
                @endforeach
                </tbody>
               
   
            </table>
        </div>
    </div>

 




@endsection




