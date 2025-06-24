<?php

namespace App\Http\Controllers\Web\Music;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view()
    {
        $posts = Post::with('user')->where('visibility', true)->latest()->get();

        return view('home', compact('posts'));
    }
}
