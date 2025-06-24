<?php

namespace App\Http\Controllers\Web\Music;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\CreatePostRequest;
use App\Http\Resources\Api\Spotify\RecomendationsResource;
use App\Models\Post;
use App\Models\Spotify;
use App\Services\EmotionDetectionService;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function view()
    {
        return view('submit');
    }

    public function create(CreatePostRequest $request)
    {
        // $spotifyService = app(SpotifyService::class);
        // $spotifyData = $spotifyService->detail($request->type, $request->spotify_id);
        // Spotify::create(collect($spotifyData)->only('type', 'uri')->toArray());

        Auth::user()->posts()->create($request->all());

        return response()->json(['success' => true], 201);
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();
        return redirect()->back()->with('status', 'Post deleted.');
    }

    public function publish(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $post->visibility = !$post->visibility;
        $post->save();

        return redirect()->back()->with('status', 'Post ' . ($post->visibility ? 'published' : 'unpublished'));
    }

    public function getRecomendations(Request $request)
    {
        $spotifyService = app(SpotifyService::class);
        $recomendations = $spotifyService->recommendations($request->text);

        return response()->json($recomendations['tracks']['items'] ? RecomendationsResource::collection($recomendations['tracks']['items']) : []);
    }
}
