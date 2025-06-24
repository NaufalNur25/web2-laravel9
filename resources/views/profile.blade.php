<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Music</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/content-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/modal.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://open.spotify.com/embed/iframe-api/v1" async></script>
</head>
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function logout() {

    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    });
</script>

<body>
    <nav>
        <a href="{{ url('/home') }}">
            <button>
                <i class="ri-home-line"></i>
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
                <i class="ri-user-fill"></i>
                <p>Profile</p>
            </button>
        </a>
    </nav>
    <main>
        <div class="user-profile">
            <p class="username">{{ '@' . Auth::user()->username }}</p>
            <p class="post">{{ $posts->count() }} Post</p>
            <button onclick="openModal('modal-confirm')">
                <i class="ri-settings-line"></i>
            </button>
        </div>
        <div class="posted">
            @foreach ($posts as $post)
                <x-content-card
                    :id="$post->id"
                    :userHavePost="auth()->id() === $post->user_id"
                    :visibility="$post->visibility ?? false"
                    :postedAt="$post->created_at->diffForHumans()"
                    :username="$post->user->username ?? 'Unknown'"
                    :uri="$post->spotify_id ?? ''"
                    :description="$post->content ?? 'No Description'" />
            @endforeach
        </div>
    </main>

    <x-modal id="modal-confirm" title="Settings">
        <div class="modal-action">
            <form id="logout-form" action="/logout" method="POST" class="inline">
                @csrf
                <button type="submit" class="button-modal">Log Out</button>
            </form>
            <button class="button-modal" onclick="closeModal('modal-confirm')">Cancel</button>
        </div>
    </x-modal>
</body>

</html>
