@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tweet Your Idea</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('post.store') }}" >
                        <div class="form-group">
                            <label class="label" for="i">add image </label>
                            <input type="file" id="i" name="image" >
                            <br>
                            <label class="label" for="v">add video: </label>
                            <input type="file" id="v" name="video" >
                            @csrf
                            <label class="label">Title: </label>
                            <input type="text" name="title" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label class="label">Your Text: </label>
                            <textarea name="body" rows="10" cols="30" class="form-control" required></textarea>
                           
                        </div>
                        <div class="form-group">
                            <label class="label">Hashtags: </label>
                            <input type="text" name="name" class="form-control" placeholder="Enter hashtags separated by commas"/>
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
@endsection