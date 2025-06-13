<?php

namespace App\Http\Controllers\Web\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function view()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $login = $request->input('username');
        $password = $request->input('password');

        $user = \App\Models\User::where('email', $login)->orWhere('username', $login)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors(['username' => 'Invalid credentials'])->onlyInput('username');
    }
}
