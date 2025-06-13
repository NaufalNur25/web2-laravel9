<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Authentication;

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

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::get('/', fn() => redirect('/login'));
