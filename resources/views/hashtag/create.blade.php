<h1>Create Hashtag</h1>
    @if (session('success'))
        <div>
            {{  message('success') }}
        </div>
    @endif
    @if (session('error'))
        <div>
            {{ message('error')  }}
        </div>
    @endif

    <form action="" method="POST">
        @csrf
        <div>
            <label for="name">Hashtag Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>
        <button type="submit">Create Hashtag</button>
    </form>
