<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function username()
{
    return 'username';
}

    public function login (Request $request):RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // dd($credentials);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home')
                    ->with('success', 'Login Berhasil');
        }
        return back()->with('error', 'Username atau password salah')->onlyInput('username');


    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('Logout berhasil');
    }
}
