
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
           
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
       
            <table class="table table-bordered">
                 
                <thead>
                  
                   
                    <th>write your idea</th>
                    <th>follow</th>
                    <th>unfollow</th>
                    <th  width="250px" style="color:blue">comments</th>
                    <th  width="20px">like</th>
                    <th  width="20px">dislike</th>
                    <th style="color: red" width="150px">Reports</th>
                    <th style="text-align:center">retweet</th>
                </thead>
                <tbody>
               
               
                <tr>
                    
                  
                    <td>  
                        
 {{-- comment form --}}
 @auth
                        <div class="container">
                            <div>
                                <div >
                                    <div >
                                        <div >your idea</div>
                                        <div>
                                    
                                            <form method="post" action="{{route('posts.comments.store',$post->id)}}">
                                               
                                                <input type="hidden"  name="post_id" value="{{$post->id}}" />
                                               
                                                <div class="form-group">
                                                    @csrf
                                                   
                                                <div class="form-group">
                                                   
                                                    <textarea name="body" placeholder="..." class="form-control" ></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-success" />
                                                </div>
                                            </form>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </td>
      @else
      <a href="{{route('login')}}">login</a> then you can submit comment
                          
                        
    @endauth
    
<td>
        <form action="{{ route('follow', $user->id) }}" method="POST">
            @csrf
            <button type="submit">Follow</button>
        </form>
</td>
<td>
        <form action="{{ route('unfollow', $user->id) }}" method="POST">
            @csrf
            <button type="submit">unFollow</button>
        </form>
</td>

                    {{-- comment in index --}}

                    
                    <td> @foreach($post->comments as $comment)
                        {{$comment->body}}<hr>
                        @endforeach</td>

                        
                        {{-- Like service --}}

                    <td>
                    <form action="{{ route('like.post', $post->id) }}"
                        method="post">
                        @csrf
                        <button
                            class="{{ $post->liked() ? 'bg-blue-600' : '' }} px-2 py-1 text-black bg-gray-200">
                            like 
                        </button>
                    </form>

            </td>
                <td>
                        <form action="{{ route('unlike.post', $post->id) }}"
                             method="post">
                          @csrf
                         <button
                          class="{{ $post->liked() ? 'block' : 'hidden'  }} px-2 py-1 text-black bg-red-200">
                         unlike
                         </button>
                         </form>
                </td>
{{--  --}}

                {{-- Report --}}
            <td>

              @auth
                <form action="{{route('post.report',$post->id)}}" method="POST">
                    @csrf
                    <input type="hidden"  name="post_id" value="{{$post->id}}" />
                      <input style="color: red" type="submit" value="ReportPost">
                    </form>
             @else
                    <a href="{{route('login')}}">login</a> then you can submit report

            @endauth

            </td>
{{--  --}}



            {{-- Retweet --}}

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


  {{--  --}}
         
                </tr>
              
                
          
                </tbody>
   
            </table>
            <div>

             
            <h1> <a href="/">home</a> </h1>
            <p5> {{$post->body}}</p5>
 @if($post->video)
            <div>


        <video width="320" height="240" controls>
                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
        </video>
    </div>

  @else
    <div> no video</div>
@endif
    <div>
    </div> 
    ///
    @if($post->image)
    <div>
        <img width="320" height="240" controls src="{{ asset('storage/' . $post->image) }}">
    </div>         
 @else
    <div> no image</div>
@endif    
                
        </div>
        </div>
        </div>
    </div>
</div>

