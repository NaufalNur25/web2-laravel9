<div class="content-card">
    <p>@ {{ $username }}</p>
    <iframe id="embed-iframe" data-spotify-id="{{ $uri }}"></iframe>
    <p>{{ $description }}</p>

</div>


<script>
    window.onSpotifyIframeApiReady = IFrameAPI => {
        const element = document.getElementById('embed-iframe');
        const spotifyId = element.dataset.spotifyId;
        const options = {
            uri: `spotify:track:${spotifyId}`,
        };
        const callback = EmbedController => {
            console.log("Embed ready for", options.uri);
        };
        IFrameAPI.createController(element, options, callback);
    };
</script>
