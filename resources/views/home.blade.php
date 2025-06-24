<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/content-card.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <script src="https://open.spotify.com/embed/iframe-api/v1" async></script>

</head>

<body>
    <nav>
        <a href="{{ url('/home') }}">
            <button>
                <i class="ri-home-fill"></i>
                <p>Home</p>
            </button>
        </a>
        <a href="{{ url('/create') }}">
            <button>
                <i class="ri-add-box-line"></i>
                <p>Create</p>
            </button>
        </a>
        <a href="{{ url('/profile') }}">
            <button>
                <i class="ri-user-line"></i>
                <p>Profile</p>
            </button>
        </a>
    </nav>
    <main>
        <div class="posted">
            @foreach ($posts as $index => $post)
            <x-content-card
                :id="'iframe-' . $index"
                :username="$post->user->username ?? 'Unknown'"
                :uri="$post->spotify_id ?? ''"
                :description="$post->content ?? 'No Description'" />
            @endforeach
        </div>
    </main>

</body>

</html>