<div class="content-card">
    <p>@ {{ $username }}</p>
    <iframe id="{{ $id }}" class="spotify-embed" data-spotify-id="{{ $uri }}"></iframe>
    <p>{{ $description }}</p>
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