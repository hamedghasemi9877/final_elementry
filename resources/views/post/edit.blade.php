@include('layouts.app')



  <form method="POST" enctype="multipart/form-data" action="/posts/{{$post->id}}/update" >
	@csrf
	@method('PUT')
	<div class="form-group">
		<label class="label" for="i">add image </label>
		<input type="file" id="i" name="image" value="{{$post->image}}" >
		<br>
		<label class="label" for="v">add video: </label>
		<input type="file" id="v" name="video" value="{{$post->video}}" >
		
		<label class="label">Title: </label>
		<input type="text" name="title" class="form-control" value="{{$post->title}}" required/>
	</div>

	<div class="form-group">
		<label class="label">Your text: </label>
		<input type="text" name="body" class="form-control" value="{{$post->body}}" required/>
	   
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-success" />
	</div>
</form>
