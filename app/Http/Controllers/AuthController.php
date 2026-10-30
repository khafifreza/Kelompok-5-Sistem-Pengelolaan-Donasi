<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login & register tampil sebagai modal di layout, bukan halaman terpisah.
    // Rute GET tetap ada (dipakai middleware `auth`) dan mengarahkan ke beranda.
    public function showLogin()
    {
        return redirect()->route('home')->with('open_modal', 'loginModal');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->onlyInput('email')
                ->with('open_modal', 'loginModal');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Login berhasil!');
    }

    public function showRegister()
    {
        return redirect()->route('home')->with('open_modal', 'registerModal');
    }

    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/^[0-9+\s\-]{9,20}$/'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'phone.regex' => 'Nomor WhatsApp tidak valid.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        // Password otomatis di-hash oleh cast 'hashed' pada model User.
        User::create($validated);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}
