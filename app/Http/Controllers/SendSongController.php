<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendSongController extends Controller
{
    public function formSubmit()
    {
        return view('submit');
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'recipient' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'song' => 'required|string|max:255',
        ]);

        #TODO:Process song

        return redirect()->back()->with('success', 'Song sent successfully! 🎵');
    }
}
