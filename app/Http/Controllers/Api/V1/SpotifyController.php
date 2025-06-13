<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Spotify\DropdownTrackResource;
use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    private $spotifyService;

    public function __construct()
    {
        $this->spotifyService = new SpotifyService();
    }

    public function dropdownArtists(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $result = $this->spotifyService->search([
            'q' => 'artist:' . $request->input('name'),
            'type' => 'artist'
        ], 10);
        return response()->json($result['artists']['items'] ?? []);
    }

    public function dropdownAlbums(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $result = $this->spotifyService->search([
            'q' => 'album:' . $request->input('name'),
            'type' => 'album'
        ], 10);

        return response()->json($result['albums']['items'] ?? []);
    }

    public function dropdownTracks(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $result = $this->spotifyService->search([
            'q' => 'track:' . $request->input('name'),
            'type' => 'track'
        ], 10);

        return response()->json($result['tracks']['items'] ? DropdownTrackResource::collection($result['tracks']['items']) : []);
    }

    public function dropdownPlaylists(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $result = $this->spotifyService->search([
            'q' => 'playlist:' . $request->input('name'),
            'type' => 'playlist'
        ], 10);

        return response()->json($result['playlists']['items'] ?? []);
    }
}
