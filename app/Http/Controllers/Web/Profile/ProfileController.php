<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function view()
    {
        $user = auth()->user();
        $posts = $user->posts()->latest()->get();

        return view('profile', compact('posts'));
    }
}
