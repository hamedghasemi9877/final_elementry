@extends('layouts.app')  
@section('content')

   @if(auth()->check())

      <div class="btn btn-info" style="float: right"><a href="{{ route('profile.index',$user->id)}}">your profile</a> </div><br><br>
   
   @endif

{{--  --}}


{{-- Suggestions with follow --}}
@auth

      <p1>Suggested with <u> follow</u> system:</p1><br>

   @if ($suggestedUsers->isNotEmpty())
  
          @foreach($suggestedUsers as $suggestedUser)

               @if(auth()->user()->id!==$suggestedUser->id)

                    <p1>{{$suggestedUser->name}}

                        <form action="{{ route('follow',$suggestedUser->id) }}" method="POST">

                              @csrf

                              <button type="submit">Follow</button>

                        </form>

                    </p1> 
    
               @endif

           @endforeach

    @endif
<hr>
{{-- Suggestions with like --}}

<p1>Suggested with <u> like</u> system:</p1><br>

  @foreach($users1 as $user1)

        @if(!($user->isfollowing($user1->id)))

                <p1>{{$user1->name}}

                     <form action="{{ route('follow',$user1->id) }}" method="POST">

                                 @csrf

                                 <button type="submit">Follow</button>

                     </form>
                </p1> 

        @endif

  @endforeach



@endauth
<hr>
{{--  --}}

<!-- Sorted posts -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4 style="color: rgb(255, 0, 0); text-align: center">SORT with these methods</h4>
            <div style="display: flex; justify-content: space-around;">
                <a href="{{ route('posts.sort', ['sort' => 'newest']) }}" style="color: rgb(9, 255, 0); display: inline-block; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; text-align: center; background-color: #fff; border: 1px solid rgb(9, 255, 0); text-decoration: none; margin: 0 10px;">newest</a>
                <a href="{{ route('posts.sort', ['sort' => 'likeable']) }}" style="color: rgb(9, 255, 0); display: inline-block; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; text-align: center; background-color: #fff; border: 1px solid rgb(9, 255, 0); text-decoration: none; margin: 0 10px;">likeable</a>
                <a href="{{ route('posts.sort', ['sort' => 'commentable']) }}" style="color: rgb(9, 255, 0); display: inline-block; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; text-align: center; background-color: #fff; border: 1px solid rgb(9, 255, 0); text-decoration: none; margin: 0 10px;">commentable</a>
            </div>
        </div>
    </div>
</div>

     
@guest
                             <div>

                                <strong>Notice!</strong> Login first for create New Tweet

                             </div> 
@endguest

            
{{-- all users --}}

   @foreach($posts as $post)

             @if(auth()->check()&& auth()->user()->id!==$user->id)

                 <p>
                     {{$post->user->name}}

                          
                         <form action="{{ route('follow',$post->user_id) }}" method="POST">
                           
                             @csrf
    
                                  <button type="submit">Follow

                                  </button>

                         </form><hr>
                 </p>

             @endif

@endforeach

             @if (session()->has('message'))
                 
                   <div style="font-size: 40px; color:rgb(10, 54, 231);text-align:left">
                     
                       {{ session('message') }}
                  
                   </div>

             @endif
             
             @if (session()->has('error'))

                     <div  style="font-size: 60px; background-color: rgb(226, 50, 85);text-align:center" >
             
                        {{ session('error') }}
              
                     </div>
          
             @endif
       
        
             @if(auth()->check()) 
         
                     <div> 

                         <a href="{{ route('post.create') }}" class="btn btn-success" style="font-size:30px">NewTweet</a>
                        
                     </div>
        
             @endif
<hr>
{{-- Hastag searach --}}

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">
            
            <div class="card">

                <div class="card-header"><br>

                    <h2 style="text-align: center;background-color: darkgrey">top Hashtags<div><img alt="" class="bg lr nr c" width="100" height="100" loading="eager" role="presentation" src="https://miro.medium.com/v2/resize:fit:512/1*lkH-hcmXV0Bks6-FFZ-VNg.png">

                </div>

                    </h2>

                    @if(auth()->check())

                        @foreach ($topHashtags as $topHashtag)

                            <p style="background-color: rgb(177, 147, 147);text-align: center"> 

                                {{$topHashtag->name}} 

                            </p>

                        @endforeach

                    @endif

                </div>

                <div class="card-body">

                    <form action="{{route('hashtag.search')}}" method="GET">

                        @csrf

                           <div class="form-group">

                                <input type="text" class="form-control"  name="search" placeholder="Search with Hashtag">

                           </div>

                             <button type="submit" class="btn btn-primary">Search

                             </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- --}}


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

                            <th style="text-align:center">creation time</th>
                    
                    
                    
                    </thead>

                        <tbody>
                  
                                  @foreach($posts as $post)

                                     @if($post->user->visibility==='public')
               
                                        <tr>
                   
                                           <td style="text-align:center">{{ $post->title }}
                                        
                                           </td>
                   
                                           <td style="text-align:center">

                                     @if($post->image!==null)

                                        <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}">
                    
                                           </td>
   
        
                                     @else

                                        <p>

                                            no image

                                        </p>  

                                     @endif

                                           </td>

                                           <td style="text-align:center">

                                     @if($post->video!==null)  

                                         <video width="200" height="150" controls>

                                             <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                  
                                         </video>

                                     @else

                                         <p>

                                             no video
 
                                         </p>  
 
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

                                            <td style="text-align:center"> 
            
                                                <form action="{{ route('like.post', $post->id) }}"method="post">
          
                                                   @csrf
           
                                                      <button>
             
                                                             like 
            
                                                      </button>
      
                                                </form><br>
            
                                                <form action="{{ route('unlike.post', $post->id) }}"method="post">
        
                                                    @csrf
       
                                                      <button>
                                                        
                                                        unlike
       
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
               
                                                </div>

                                            </td>
                           
                    
                                            <td style="text-align:center"> <a href="{{ route('profile.index',$post->user_id)}}">profile</a>
                                            
                                            </td> 
                    
                                            <td style="text-align:center">
                      
                    
                                                <form action="{{ route('follow',$post->user_id) }}" method="POST">

                                                      @csrf

                                                       <button type="submit">Follow

                                                       </button>

                                                </form><br>
                        
                                                <form action="{{ route('unfollow',$post->user_id) }}" method="POST">
                            
                                                       @csrf
                           
                                                          @method('DELETE')
                            
                                                        <button type="submit">Unfollow 

                                                        </button>
                        
                                                </form>
                  
                                            </td> 
                  
                                            <td>
                                                
                                                {{$post->created_at->format('Y/M/d')}}<br> 
                                                {{$post->created_at->format('H:i')}} 
                                            
                                            </td>
              
                                     @endif

                   @endforeach
         
                        </tbody>
   
                </table>
           
@auth

                    <h2>posts of your Followings(private pages):</h2>

    
                <table class="table table-bordered">

                    <thead style="text-align:center">
        
          
                            <th style="text-align:center">user
                            </th>

                            <th style="text-align:center">title
                            </th>

                            <th style="text-align:center">image
                            </th>

                            <th style="text-align:center">video
                            </th>

                            <th  width="250px" style="color:blue">comments
                            </th>

                            <th  width="10px">like
                            </th>

                            <th style="color: red" width="30px">Reports
                            </th>

                            <th style="text-align:center">retweets
                            </th>

                            <th style="text-align:center">Profiles
                            </th>

                            <th style="text-align:center">FollowMethod
                            </th>
            
            
            
                    </thead>

                        <tbody>

          @if(auth()->check())
    

          @foreach ($PostsPrivateUsers as $post)
          {{-- @dd(auth()->user()->isfollowing($post->user_id)) --}}

          @if(auth()->user()->isfollowing($post->user_id))
       
                             <tr>
           
            
                                        <td style="text-align:center">

                                            {{ $post->user->name }} 

                                        </td>

                                        <td style="text-align:center">

                                            {{ $post->title }}

                                        </td>

                                        <td style="text-align:center">
               
               
          @if($post->image!==null)

                                               <img width="230" height="150" controls src="{{ asset('storage/' . $post->image) }}">

                                        


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

                         <td style="text-align:center"> 
    
                              <form action="{{ route('like.post', $post->id) }}"method="post">

                                  @csrf

                                  <button>

                                      like 

                                  </button>

                              </form><br>

                              <form action="{{ route('unlike.post', $post->id) }}"method="post">

                                  @csrf

                                  <button>
                                    
                                    unlike

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

                                  <button type="submit" class="btn btn-primary">
                                    
                                    Retweet

                                  </button>

                              </form>
  
                        </td>
                
               
                        <td style="text-align:center"> <a href="{{ route('profile.index',$post->user_id)}}">profile</a>
            
                        </td> 
            
                        <td>
            
                              <form action="{{ route('follow',$post->user_id) }}" method="POST">

                                   @csrf

                                   <button type="submit">
                        
                                         Follow

                                   </button>

                              </form><br>
                
                              <form action="{{ route('unfollow',$post->user_id) }}" method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit">
                        
                                        Unfollow

                                    </button>

                              </form>

                        </td> 
          
         @endif

             @endforeach

        @endif


        </tbody>

    </table>
    
@endauth

@endsection 