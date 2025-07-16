<div class="content-card">
    <div class="content-title">
        <div class="detail">
            <h4>{{ $username }}</h4>
            <p><i class="fa-solid fa-globe"></i> {{ $postedAt }}</p>
        </div>
<<<<<<< HEAD
        @if (@$onProfilePage)
            <span class="badge {{ $visibility ? 'primary' : 'secondary' }}">
                {{ $visibility ? 'Posted' : 'Private' }}
            </span>
=======
        @if (@$useForProfile)
        <span class="badge {{ $visibility ? 'primary' : 'secondary' }}">
            {{ $visibility ? 'Posted' : 'Private' }}
        </span>
>>>>>>> cef375fa51999e83cd1943377bf474ef85c27ef3
        @endif
    </div>
    <div class="content-description">
        <p>{{ $description }}</p>
    </div>
    <iframe id="{{ $id }}" class="spotify-embed" data-spotify-id="{{ $uri }}"></iframe>
    <div class="post-actions">
<<<<<<< HEAD
        @if (@$onProfilePage)
            @auth
                @if ($userHavePost)
                    <form action="{{ route('music.visibility', $id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-btn {{ $visibility ? 'unpublish' : 'publish' }}">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span>{{ $visibility ? 'Unpublish' : 'Publish' }}</span>
                        </button>
                    </form>
                @endif
            @endauth
            @auth
                @if ($userHavePost)
                    <form action="{{ route('music.delete', $id) }}" method="POST"
                        onsubmit="return confirm('Do you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Delete Post</span>
                        </button>
                    </form>
                @endif
            @endauth
=======
        @if (@$useForProfile)
        @auth
        @if ($userHavePost)
        <form action="{{ route('music.visibility', $id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="action-btn {{ $visibility ? 'unpublish' : 'publish' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>{{ $visibility ? 'Unpublish' : 'Publish' }}</span>
            </button>
        </form>
        @endif
        @endauth
        @auth
        @if ($userHavePost)
        <form action="{{ route('music.delete', $id) }}" method="POST"
            onsubmit="return confirm('Do you want to delete this post?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn delete">
                <i class="fa-solid fa-trash-can"></i>
                <span>Delete Post</span>
            </button>
        </form>
        @endif
        @endauth
>>>>>>> cef375fa51999e83cd1943377bf474ef85c27ef3
        @endif
    </div>
</div>

<script>
    window.onSpotifyIframeApiReady = (IFrameAPI) => {
        document.querySelectorAll('.spotify-embed').forEach((element) => {
            const spotifyId = element.dataset.spotifyId;
            if (!spotifyId) return;

            const options = {
                uri: `spotify:track:${spotifyId}`,
                width: '100%',
                height: 180,
            };

            const callback = (EmbedController) => {
                console.log("Embed ready for", options.uri);
            };

            IFrameAPI.createController(element, options, callback);
        });
    };
</script>