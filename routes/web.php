<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Authentication;
use App\Http\Controllers\Web\Profile;
use App\Http\Controllers\Web\Music;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [Authentication\LoginController::class, 'view'])->name('login')->middleware('guest');
Route::post('/login', [Authentication\LoginController::class, 'login']);
Route::get('/register', [Authentication\RegisterController::class, 'view'])->middleware('guest');
Route::post('/register', [Authentication\RegisterController::class, 'register']);
Route::post('/logout', Authentication\LogoutController::class)->middleware('auth');
Route::get('/profile', [Profile\ProfileController::class, 'view'])->middleware('auth');
Route::get('/music', [Music\PostController::class, 'view'])->middleware('auth');
Route::post('/music', [Music\PostController::class, 'create'])->name('music.create')->middleware('auth');
Route::patch('/music/{post}', [Music\PostController::class, 'publish'])->name('music.visibility')->middleware('auth');
Route::delete('/music/{post}', [Music\PostController::class, 'destroy'])->name('music.delete')->middleware('auth');
Route::get('/home', [Music\HomeController::class, 'view'])->middleware('auth');

Route::get('/create', function () {
    return view('create');
})->middleware('auth');

Route::get('/', fn() => redirect('/login'));
