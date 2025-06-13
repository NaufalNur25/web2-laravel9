<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('public')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('spotify')->as('spotify.')->group(function () {
            Route::get('/artists/dropdown', [
                App\Http\Controllers\Api\V1\SpotifyController::class,
                'dropdownArtists'
            ])->name('artists.dropdown');

            Route::get('/albums/dropdown', [
                App\Http\Controllers\Api\V1\SpotifyController::class,
                'dropdownAlbums'
            ])->name('albums.dropdown');

            Route::get('/tracks/dropdown', [
                App\Http\Controllers\Api\V1\SpotifyController::class,
                'dropdownTracks'
            ])->name('tracks.dropdown');

            Route::get('/playlists/dropdown', [
                App\Http\Controllers\Api\V1\SpotifyController::class,
                'dropdownPlaylists'
            ])->name('playlists.dropdown');
        });
    });
});


Route::prefix('v1')->group(function () {
    Route::prefix('spotify')->group(function () {
         Route::post('/recommendations', [
                App\Http\Controllers\Web\Music\PostController::class,
                'getRecomendations'
            ])->name('spotify.recommendations');
    });
});
