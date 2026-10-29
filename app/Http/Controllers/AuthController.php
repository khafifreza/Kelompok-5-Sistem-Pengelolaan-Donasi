<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        return redirect()->route('home')->with('success', 'Login berhasil!');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }
}