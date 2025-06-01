<?php

use Illuminate\Http\Request;
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
                App\Http\Controllers\Api\V1\Spotify\SpotifyDropdownController::class,
                'dropdownArtists'
            ])->name('artists.dropdown');

            Route::get('/albums/dropdown', [
                App\Http\Controllers\Api\V1\Spotify\SpotifyDropdownController::class,
                'dropdownAlbums'
            ])->name('albums.dropdown');

            Route::get('/tracks/dropdown', [
                App\Http\Controllers\Api\V1\Spotify\SpotifyDropdownController::class,
                'dropdownTracks'
            ])->name('tracks.dropdown');

            Route::get('/playlists/dropdown', [
                App\Http\Controllers\Api\V1\Spotify\SpotifyDropdownController::class,
                'dropdownPlaylists'
            ])->name('playlists.dropdown');
        });
    });
});
