@if (Auth::check())
    <form method="POST" action="{{ route('retweet.store', $post->id) }}">
        @csrf
        <button type="submit" class="btn btn-primary">Retweet</button>
    </form>
@else
    <p>Please login first</p>
@endif